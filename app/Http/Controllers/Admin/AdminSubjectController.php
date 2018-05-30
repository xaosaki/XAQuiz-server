<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = new Subject();
        $this->validate($request, [
            'name'=> 'required'
        ], [
            'name.required' => 'Пожалуйста, укажите название',
        ]);
        $subject->name = $request->name;

        $subject->save();
        return redirect()->route('admin.subject.index')->with('flash_message', 'Категория вопросов добавлена!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        return view('admin.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $this->validate($request, [
            'name'=> 'required'
        ], [
            'name.required' => 'Пожалуйста, укажите название',
        ]);
        $subject->name = $request->name;

        $subject->save();
        return redirect()->route('admin.subject.index')->with('flash_message', 'Категория вопросов обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subject.index')->with('flash_message', 'Категория вопросов удалена!');
    }
}
