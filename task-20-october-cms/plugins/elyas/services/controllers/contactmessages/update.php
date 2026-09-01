<?= Form::open(['class' => 'layout']) ?>

<div class="layout-row">
    <?= $this->formRender() ?>
</div>

<div class="form-buttons">
    <div class="loading-indicator-container">

        <button
            type="submit"
            data-request="onSave"
            data-hotkey="ctrl+s, cmd+s"
            data-load-indicator="Saving..."
            class="btn btn-primary">
            Save
        </button>

        <button
            type="button"
            data-request="onDelete"
            data-load-indicator="Deleting..."
            data-request-confirm="Are you sure you want to delete this message?"
            class="btn btn-danger">
            Delete
        </button>

        <a
            href="<?= Backend::url('elyas/services/contactmessages') ?>"
            class="btn btn-default">
            Cancel
        </a>

    </div>
</div>

<?= Form::close() ?>