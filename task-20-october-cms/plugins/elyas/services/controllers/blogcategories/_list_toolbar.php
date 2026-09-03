<div data-control="toolbar">
    <a
        href="<?= Backend::url('elyas/services/blogcategories/create') ?>"
        class="btn btn-primary">
        <i class="icon-plus"></i>
        New Category
    </a>

    <button
        class="btn btn-secondary"
        data-request="onDelete"
        data-request-confirm="Are you sure?"
        data-list-checked-trigger
        data-list-checked-request
        disabled>
        <i class="icon-delete"></i>
        Delete
    </button>
</div>