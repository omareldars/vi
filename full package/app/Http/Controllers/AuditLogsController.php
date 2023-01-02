<?php

namespace App\Http\Controllers;

use App\AuditLog;

class AuditLogsController extends Controller
{
    public function index()
    {
       $this->preProcessingCheck('view_log');
        $auditLogs = AuditLog::orderBy("Created_at",'DESC')->take(1000)->get();
        $TotalRec = AuditLog::count();

        return view('admin.auditLogs.index', compact('auditLogs'))->with('TotalRec',$TotalRec);
    }

    public function show(AuditLog $auditLog)
    {
        $this->preProcessingCheck('view_log');
        return view('admin.auditLogs.show', compact('auditLog'));
    }
    public function destroy()
    {
        $this->preProcessingCheck('manage_log');
        AuditLog::truncate();
        return back();
    }
}