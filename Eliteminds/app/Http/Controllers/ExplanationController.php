<?php

namespace App\Http\Controllers;

use App\Repository\ExplanationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExplanationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExplanationRepositoryInterface $explanationRepository
     * @return Response
     */
    public function index(ExplanationRepositoryInterface $explanationRepository)
    {
        $explanations = $explanationRepository->all(request()
            ->only(['word', 'chapter_id', 'course_id'])
        );
        return view('admin.explanation.index')->with('explanations', $explanations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.explanation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ExplanationRepositoryInterface $explanationRepository
     * @return Response
     */
    public function store(Request $request, ExplanationRepositoryInterface $explanationRepository)
    {
        $this->validate($request, [
            'title'         => 'required',
            'explanation'   => 'required',
        ]);

        $explanation_id = $explanationRepository->save($request->only(['title', 'explanation', 'course_id', 'chapter_id']));

        return response()->json([
            'explanation_id'   => $explanation_id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param ExplanationRepositoryInterface $explanationRepository
     * @return Response
     */
    public function show($id, ExplanationRepositoryInterface $explanationRepository)
    {
        return response()->json($explanationRepository->find($id)->first(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.explanation.edit')->with('post_id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param ExplanationRepositoryInterface $explanationRepository
     * @return Response
     */
    public function update(Request $request, $id, ExplanationRepositoryInterface $explanationRepository)
    {
        $this->validate($request, [
            'title'         => 'required',
            'explanation'   => 'required',
        ]);

        $explanationRepository->update($id, $request->only(['title', 'explanation', 'chapter_id', 'course_id']));

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param ExplanationRepositoryInterface $explanationRepository
     * @return Response
     */
    public function destroy($id, ExplanationRepositoryInterface $explanationRepository)
    {
        $explanationRepository->delete($id);
        return back()->with('success', 'Explanation Has been Deleted');
    }
}
