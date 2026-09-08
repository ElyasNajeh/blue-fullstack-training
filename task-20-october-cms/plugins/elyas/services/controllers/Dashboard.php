<?php

namespace Elyas\Services\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;
use Elyas\Services\Models\BlogPost;
use Elyas\Services\Models\Document;
use Elyas\Services\Models\ContactMessage;
use Elyas\Services\Models\Service;
use Elyas\Services\Models\AuditLog;

class Dashboard extends Controller
{
    public $requiredPermissions = [
        'elyas.services.dashboard'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext(
            'Elyas.Services',
            'services',
            'dashboard'
        );
    }

    public function index()
    {
        $this->pageTitle = 'Dashboard';

        // KPI Cards
        $this->vars['publishedBlogPosts'] = BlogPost::where(
            'status',
            'published'
        )->count();

        $this->vars['draftBlogPosts'] = BlogPost::where(
            'status',
            'draft'
        )->count();

        $this->vars['totalDocuments'] = Document::count();

        $this->vars['totalDownloads'] = Document::sum(
            'download_count'
        );

        $this->vars['newContactMessages'] = ContactMessage::where(
            'status',
            'new'
        )->count();

        $this->vars['totalServices'] = Service::count();

        // Recent Activity
        $this->vars['latestMessages'] = ContactMessage::orderByDesc('created_at')
            ->limit(5)
            ->get();

        $this->vars['recentAuditLogs'] = AuditLog::orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Backend links
        $this->vars['contactMessagesUrl'] = Backend::url(
            'elyas/services/contactmessages'
        );

        $this->vars['auditLogsUrl'] = Backend::url(
            'elyas/services/auditlogs'
        );
    }
}
