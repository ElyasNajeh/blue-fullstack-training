<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const pageId = route.params.id

// =========================
// Page
// =========================

const title = ref('')
const slug = ref('')
const content = ref('')
const statusValue = ref('draft')

const loading = ref(true)
const updating = ref(false)
const error = ref('')
const validationErrors = ref({})

// =========================
// Content Blocks
// =========================

const blocks = ref([])

const blockType = ref('text')
const blockData = ref('')

const addingBlock = ref(false)
const blockError = ref('')

const editingBlockId = ref(null)
const editBlockType = ref('')
const editBlockData = ref('')

// =========================
// Load Page
// =========================

async function loadPage() {
  try {
    loading.value = true
    error.value = ''

    const response = await fetch(`${API_BASE_URL}/manage/pages`, {
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
    })

    if (!response.ok) {
      throw new Error('Failed to load page')
    }

    const result = await response.json()

    const page = result.data.find((page) => page.id === Number(pageId))

    if (!page) {
      error.value = 'Page not found.'
      return
    }

    title.value = page.title
    slug.value = page.slug
    content.value = page.content
    statusValue.value = page.status

    blocks.value = page.content_blocks || []
  } catch (err) {
    error.value = 'Failed to load page.'
    console.log(err)
  } finally {
    loading.value = false
  }
}

// =========================
// Update Page
// =========================

async function updatePage() {
  try {
    updating.value = true
    error.value = ''
    validationErrors.value = {}

    const response = await fetch(`${API_BASE_URL}/pages/${pageId}`, {
      method: 'PUT',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        title: title.value.trim(),
        slug: slug.value.trim(),
        content: content.value.trim(),
        status: statusValue.value,
      }),
    })

    const result = await response.json()

    if (response.status === 422) {
      validationErrors.value = result.errors
      return
    }

    if (!response.ok) {
      error.value = 'Failed to update page.'
      return
    }

    router.push('/manage/pages')
  } catch (err) {
    error.value = 'Server error. Please try again.'
    console.log(err)
  } finally {
    updating.value = false
  }
}

// =========================
// Add Block
// =========================

async function addBlock() {
  try {
    addingBlock.value = true
    blockError.value = ''

    let parsedData

    try {
      parsedData = JSON.parse(blockData.value)
    } catch {
      blockError.value = 'Block data must be valid JSON.'
      return
    }

    const response = await fetch(`${API_BASE_URL}/pages/${pageId}/blocks`, {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        type: blockType.value,
        position: blocks.value.length + 1,
        data: parsedData,
      }),
    })

    const result = await response.json()

    if (!response.ok) {
      blockError.value = result.message || 'Failed to create block.'
      return
    }

    blocks.value.push(result.data)

    blockType.value = 'text'
    blockData.value = ''
  } catch (err) {
    blockError.value = 'Failed to create block.'
    console.log(err)
  } finally {
    addingBlock.value = false
  }
}

// =========================
// Start Editing Block
// =========================

function startEditBlock(block) {
  editingBlockId.value = block.id
  editBlockType.value = block.type

  editBlockData.value = JSON.stringify(block.data, null, 2)

  blockError.value = ''
}

// =========================
// Cancel Editing
// =========================

function cancelEditBlock() {
  editingBlockId.value = null
  editBlockType.value = ''
  editBlockData.value = ''
}

// =========================
// Update Block
// =========================

async function updateBlock(block) {
  try {
    blockError.value = ''

    let parsedData

    try {
      parsedData = JSON.parse(editBlockData.value)
    } catch {
      blockError.value = 'Block data must be valid JSON.'
      return
    }

    const response = await fetch(`${API_BASE_URL}/blocks/${block.id}`, {
      method: 'PUT',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        type: editBlockType.value,
        position: block.position,
        data: parsedData,
      }),
    })

    const result = await response.json()

    if (!response.ok) {
      blockError.value = result.message || 'Failed to update block.'
      return
    }

    const index = blocks.value.findIndex((item) => item.id === block.id)

    if (index !== -1) {
      blocks.value[index] = result.data
    }

    cancelEditBlock()
  } catch (err) {
    blockError.value = 'Failed to update block.'
    console.log(err)
  }
}

// =========================
// Delete Block
// =========================

async function deleteBlock(id) {
  const confirmed = window.confirm('Are you sure you want to delete this block?')

  if (!confirmed) {
    return
  }

  try {
    blockError.value = ''

    const response = await fetch(`${API_BASE_URL}/blocks/${id}`, {
      method: 'DELETE',

      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
    })

    if (!response.ok) {
      blockError.value = 'Failed to delete block.'
      return
    }

    blocks.value = blocks.value.filter((block) => block.id !== id)

    await saveBlockOrder()
  } catch (err) {
    blockError.value = 'Failed to delete block.'
    console.log(err)
  }
}

// =========================
// Move Block
// =========================

async function moveBlock(index, direction) {
  const newIndex = index + direction

  if (newIndex < 0 || newIndex >= blocks.value.length) {
    return
  }

  const temp = blocks.value[index]

  blocks.value[index] = blocks.value[newIndex]
  blocks.value[newIndex] = temp

  await saveBlockOrder()
}

// =========================
// Save Block Order
// =========================

async function saveBlockOrder() {
  try {
    blockError.value = ''

    const orderedBlocks = blocks.value.map((block, index) => ({
      id: block.id,
      position: index + 1,
    }))

    const response = await fetch(`${API_BASE_URL}/pages/${pageId}/blocks/reorder`, {
      method: 'PUT',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        blocks: orderedBlocks,
      }),
    })

    if (!response.ok) {
      blockError.value = 'Failed to reorder blocks.'
      await loadPage()
      return
    }

    blocks.value.forEach((block, index) => {
      block.position = index + 1
    })
  } catch (err) {
    blockError.value = 'Failed to reorder blocks.'
    console.log(err)

    await loadPage()
  }
}

// =========================
// Back
// =========================

function goBack() {
  router.push('/manage/pages')
}

// =========================
// Mounted
// =========================

onMounted(() => {
  loadPage()
})
</script>

<template>
  <section class="page-form">
    <h1>Edit Page</h1>

    <!-- Loading -->
    <p v-if="loading">Loading page...</p>

    <!-- Page Not Found / Load Error -->
    <div v-else-if="error && !title">
      <p>{{ error }}</p>

      <button type="button" @click="goBack">Back to Pages</button>
    </div>

    <template v-else>
      <!-- =========================
           Page Form
      ========================== -->

      <form @submit.prevent="updatePage">
        <div>
          <label for="title">Title</label>

          <input id="title" v-model="title" type="text" />

          <p v-if="validationErrors.title">
            {{ validationErrors.title[0] }}
          </p>
        </div>

        <div>
          <label for="slug">Slug</label>

          <input id="slug" v-model="slug" type="text" />

          <p v-if="validationErrors.slug">
            {{ validationErrors.slug[0] }}
          </p>
        </div>

        <div>
          <label for="content">Content</label>

          <textarea id="content" v-model="content" rows="8"></textarea>

          <p v-if="validationErrors.content">
            {{ validationErrors.content[0] }}
          </p>
        </div>

        <div>
          <label for="status">Status</label>

          <select id="status" v-model="statusValue">
            <option value="draft">Draft</option>

            <option value="published">Published</option>
          </select>

          <p v-if="validationErrors.status">
            {{ validationErrors.status[0] }}
          </p>
        </div>

        <div class="form-actions">
          <button type="button" class="back-btn" @click="goBack">Back</button>

          <button type="submit" class="update-btn" :disabled="updating">
            {{ updating ? 'Updating...' : 'Update Page' }}
          </button>
        </div>

        <p v-if="error">
          {{ error }}
        </p>
      </form>

      <!-- =========================
           Content Blocks
      ========================== -->

      <section class="blocks-section">
        <h2>Content Blocks</h2>

        <!-- Add Block -->

        <div class="add-block">
          <h3>Add Block</h3>

          <div>
            <label for="block-type"> Block Type </label>

            <select id="block-type" v-model="blockType">
              <option value="hero">Hero</option>

              <option value="text">Text</option>

              <option value="cta">Call to Action</option>

              <option value="features">Feature List</option>
            </select>
          </div>

          <div>
            <label for="block-data"> Block Data (JSON) </label>

            <textarea
              id="block-data"
              v-model="blockData"
              rows="6"
              placeholder='{"title": "Welcome to Blue"}'
            ></textarea>
          </div>

          <button type="button" class="add-block-btn" :disabled="addingBlock" @click="addBlock">
            {{ addingBlock ? 'Adding...' : 'Add Block' }}
          </button>
        </div>

        <!-- Block Error -->

        <p v-if="blockError" class="block-error">
          {{ blockError }}
        </p>

        <!-- Empty Blocks -->

        <p v-if="blocks.length === 0" class="empty-blocks">No content blocks yet.</p>

        <!-- Existing Blocks -->

        <div v-else class="blocks-list">
          <article v-for="(block, index) in blocks" :key="block.id" class="block-card">
            <div class="block-header">
              <div>
                <h3>
                  {{ block.type }}
                </h3>

                <span> Position: {{ block.position }} </span>
              </div>

              <!-- Ordering -->

              <div class="order-actions">
                <button type="button" :disabled="index === 0" @click="moveBlock(index, -1)">
                  ↑
                </button>

                <button
                  type="button"
                  :disabled="index === blocks.length - 1"
                  @click="moveBlock(index, 1)"
                >
                  ↓
                </button>
              </div>
            </div>

            <!-- Normal Block Display -->

            <template v-if="editingBlockId !== block.id">
              <pre>{{ JSON.stringify(block.data, null, 2) }}</pre>

              <div class="block-actions">
                <button type="button" class="edit-block-btn" @click="startEditBlock(block)">
                  Edit
                </button>

                <button type="button" class="delete-block-btn" @click="deleteBlock(block.id)">
                  Delete
                </button>
              </div>
            </template>

            <!-- Edit Block -->

            <div v-else class="edit-block">
              <div>
                <label> Block Type </label>

                <select v-model="editBlockType">
                  <option value="hero">Hero</option>

                  <option value="text">Text</option>

                  <option value="cta">Call to Action</option>

                  <option value="features">Feature List</option>
                </select>
              </div>

              <div>
                <label> Block Data (JSON) </label>

                <textarea v-model="editBlockData" rows="7"></textarea>
              </div>

              <div class="block-actions">
                <button type="button" class="save-block-btn" @click="updateBlock(block)">
                  Save
                </button>

                <button type="button" class="cancel-block-btn" @click="cancelEditBlock">
                  Cancel
                </button>
              </div>
            </div>
          </article>
        </div>
      </section>
    </template>
  </section>
</template>
<style scoped>
.page-form {
  width: 100%;
  max-width: 900px;
  min-height: 550px;
  margin: 0 auto;
  padding: 60px 25px;
}

.page-form > h1 {
  margin-bottom: 30px;
  color: var(--secondary-color);
  font-size: 2rem;
  font-weight: 700;
  text-align: center;
}

/* =========================
   Page Form
========================= */

.page-form > form {
  padding: 35px;
  background-color: var(--white-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-form > form > div:not(.form-actions) {
  display: flex;
  flex-direction: column;
  margin-bottom: 22px;
}

.page-form label {
  margin-bottom: 8px;
  color: var(--secondary-color);
  font-size: 0.95rem;
  font-weight: 600;
}

.page-form input,
.page-form textarea,
.page-form select {
  width: 100%;
  padding: 12px 15px;
  background-color: var(--white-color);
  color: var(--text-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  font-family: inherit;
  font-size: 0.95rem;
  outline: none;
  transition: var(--transition);
}

.page-form textarea {
  resize: vertical;
}

.page-form input:focus,
.page-form textarea:focus,
.page-form select:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

/* Validation */

.page-form > form > div > p {
  margin-top: 7px;
  color: #dc3545;
  font-size: 0.85rem;
  font-weight: 500;
}

/* =========================
   Page Actions
========================= */

.form-actions {
  display: flex;
  gap: 12px;
  margin-top: 10px;
}

.form-actions button {
  flex: 1;
  padding: 12px 20px;
  border-radius: var(--border-radius);
  font-family: inherit;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.update-btn {
  background-color: var(--primary-color);
  color: var(--white-color);
  border: 1px solid var(--primary-color);
}

.update-btn:hover:not(:disabled) {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);
  transform: translateY(-2px);
}

.back-btn {
  background-color: var(--white-color);
  color: var(--secondary-color);
  border: 1px solid var(--border-color);
}

.back-btn:hover {
  background-color: #f1f3f5;
}

.update-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* =========================
   Content Blocks Section
========================= */

.blocks-section {
  margin-top: 45px;
}

.blocks-section > h2 {
  margin-bottom: 25px;
  color: var(--secondary-color);
  font-size: 1.7rem;
  font-weight: 700;
}

/* =========================
   Add Block
========================= */

.add-block {
  margin-bottom: 30px;
  padding: 30px;
  background-color: var(--white-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.add-block h3 {
  margin-bottom: 20px;
  color: var(--secondary-color);
  font-size: 1.2rem;
}

.add-block > div {
  display: flex;
  flex-direction: column;
  margin-bottom: 18px;
}

.add-block textarea {
  min-height: 130px;
}

.add-block-btn {
  width: 100%;
  padding: 12px 20px;
  background-color: var(--primary-color);
  color: var(--white-color);
  border: none;
  border-radius: var(--border-radius);
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.add-block-btn:hover:not(:disabled) {
  background-color: var(--secondary-color);
  transform: translateY(-2px);
}

.add-block-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* =========================
   Blocks List
========================= */

.blocks-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.block-card {
  padding: 25px;
  background-color: var(--white-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
}

.block-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 18px;
}

.block-header h3 {
  margin-bottom: 4px;
  color: var(--secondary-color);
  font-size: 1.15rem;
  text-transform: capitalize;
}

.block-header span {
  color: #777;
  font-size: 0.85rem;
}

/* =========================
   JSON Display
========================= */

.block-card pre {
  margin: 0 0 18px;
  padding: 15px;
  overflow-x: auto;
  background-color: #f6f7f9;
  color: var(--text-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  font-size: 0.85rem;
  line-height: 1.6;
  white-space: pre-wrap;
}

/* =========================
   Order Buttons
========================= */

.order-actions {
  display: flex;
  gap: 7px;
}

.order-actions button {
  width: 38px;
  height: 38px;
  background-color: var(--white-color);
  color: var(--secondary-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
}

.order-actions button:hover:not(:disabled) {
  background-color: #f1f3f5;
}

.order-actions button:disabled {
  opacity: 0.35;
  cursor: not-allowed;
}

/* =========================
   Block Actions
========================= */

.block-actions {
  display: flex;
  gap: 10px;
}

.block-actions button {
  padding: 10px 18px;
  border-radius: var(--border-radius);
  font-family: inherit;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.edit-block-btn,
.save-block-btn {
  background-color: var(--primary-color);
  color: var(--white-color);
  border: 1px solid var(--primary-color);
}

.edit-block-btn:hover,
.save-block-btn:hover {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);
}

.delete-block-btn {
  background-color: #dc3545;
  color: #fff;
  border: 1px solid #dc3545;
}

.delete-block-btn:hover {
  background-color: #bb2d3b;
}

.cancel-block-btn {
  background-color: var(--white-color);
  color: var(--secondary-color);
  border: 1px solid var(--border-color);
}

.cancel-block-btn:hover {
  background-color: #f1f3f5;
}

/* =========================
   Edit Block
========================= */

.edit-block {
  padding-top: 5px;
}

.edit-block > div:not(.block-actions) {
  display: flex;
  flex-direction: column;
  margin-bottom: 18px;
}

.edit-block textarea {
  min-height: 150px;
}

/* =========================
   Messages
========================= */

.block-error {
  margin-bottom: 20px;
  padding: 12px 15px;
  background-color: #f8d7da;
  color: #842029;
  border: 1px solid #f5c2c7;
  border-radius: var(--border-radius);
  font-size: 0.9rem;
}

.empty-blocks {
  padding: 25px;
  background-color: var(--white-color);
  color: #777;
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  text-align: center;
}

/* =========================
   Loading / Page Error
========================= */

.page-form > p,
.page-form > div {
  padding: 25px;
  background-color: var(--white-color);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  text-align: center;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-form > div button {
  margin-top: 15px;
  padding: 10px 20px;
  background-color: var(--primary-color);
  color: var(--white-color);
  border: none;
  border-radius: var(--border-radius);
  font-weight: 600;
  cursor: pointer;
}

/* =========================
   Responsive
========================= */

@media (max-width: 768px) {
  .page-form {
    padding: 50px 20px;
  }

  .page-form > form,
  .add-block {
    padding: 25px;
  }

  .block-header {
    align-items: flex-start;
  }
}

@media (max-width: 480px) {
  .page-form {
    padding: 40px 15px;
  }

  .page-form > h1 {
    font-size: 1.6rem;
  }

  .page-form > form,
  .add-block,
  .block-card {
    padding: 20px 16px;
  }

  .form-actions,
  .block-actions {
    flex-direction: column;
  }

  .block-actions button {
    width: 100%;
  }
}
</style>
