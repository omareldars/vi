<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Faq;


class FaqsController extends Controller
{
    public function index()
    {
        $this->preProcessingCheck('view_faqs');
        $faqs = Faq::get();
        return view('admin.settings.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $this->preProcessingCheck('edit_faqs');
        return view('admin.settings.faqs.create');
    }

    public function store(StoreFaqRequest $request)
    {
        $this->preProcessingCheck('edit_faqs');
        $faq = Faq::create($request->all());
        return redirect()->route('faqs.index');
    }

    public function edit(Faq $faq)
    {
        $this->preProcessingCheck('edit_faqs');
        return view('admin.settings.faqs.edit', compact( 'faq'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {

        $this->preProcessingCheck('edit_faqs');
        if (!$request->published) {
            $faq->update($request->all()+ ['published' => null]);
        }
        else {
            $faq->update($request->all()+ ['published' => true]);
        }
        return redirect()->route('faqs.index');
    }

    public function show(Faq $faq)
    {
        $this->preProcessingCheck('view_faqs');
        return view('admin.settings.faqs.show', compact('faq'));
    }

    public function destroy(Faq $faq)
    {
        $this->preProcessingCheck('edit_faqs');
        $faq->delete();
        return back();
    }
}
