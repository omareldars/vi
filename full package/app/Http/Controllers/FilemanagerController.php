<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilemanagerController extends Controller
{
    public function index() {
        if (Auth::user()->can('manage_myfiles')){
            return view('admin.filemanager');}
            else {abort(401);}
    }
    public function showfile($id,$filename) {
        if (Auth::id() == $id || Auth::user()->can('view_allfiles')) {
            $storagePath = storage_path('app/uploads/files/' . $id . '/' . $filename);
            return response()->file($storagePath);
        } else {abort(401);}
    }
    public function showimage($id,$filename) {
        if (Auth::id() == $id || Auth::user()->can('view_allfiles')) {
            $storagePath = storage_path('app/uploads/photos/' . $id . '/' . $filename);
            return response()->file($storagePath);
        } else {abort(401);}
    }
    public function allfiles() {
        if (Auth::user()->can('manage_myfiles')){
            return view('admin.filemanager');}
        else {abort(401);}
    }
    public function trainingfile($filename) {
            $storagePath = storage_path('app/training/files/' . $filename);
            return response()->file($storagePath);
    }
    public function trainingimage($filename) {
            $storagePath = storage_path('app/training/photos/'. $filename);
            return response()->file($storagePath);
    }
    public function showprivate($id,$filename) {
        if (Auth::user()->can('manage_myfiles')) {
            $storagePath = storage_path('app/users/' . $id . '/' . $filename);
            return response()->file($storagePath);
        } else {
           abort(401);
        }
    }
}