<?php

namespace App\Http\Controllers\Api;

use App\Model\Document;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentStore;
use App\Http\Requests\DocumentUpdate;
use App\Http\Controllers\Controller;
use App\Http\DataGrids\DocumentDataGrid;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $document = Document::with('country', 'sector', 'subSector',
                                   'documentType', 'documentSubType')->paginate(30);
        return response()->json($document);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(DocumentDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\DocumentStore $request
     * @return Illuminate\Http\Response
     */
    public function store(DocumentStore $request)
    {
        $document = Document::create(
            $request->all()
        );

        if ($request->hasFile('document_path')) {
            $document_path = $request->file('document_path')->store('storage/documents');
            $document->document_path = $document_path;
            $document->save();
        }

        return response()->json(['error' => 0,
                                 'message' => 'Document has been created',
                                 'document' => $document]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::with('country', 'sector', 'subSector',
                                   'documentType', 'documentSubType')->find($id);

        if (!$document) {
            return response()->json([
                'error' => 1,
                'message' => 'Document with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $document ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\DocumentUpdate $request
     * @param  Integer  $id
     * @return Illuminate\Http\Response
     */
    public function update(DocumentUpdate $request, $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json([
                'error' => 1,
                'message' => 'Document with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $document->fill($request->all())->save();

        if ($updated) {
            if ($request->hasFile('document_path')) {
                $document_path = $request->file('document_path')->store('storage/documents');
                $document->document_path = $document_path;
                $document_path->save();
            }

            return response()->json([
                'error' => 0,
                'message' => 'Document has been updated',
                'document' => $document,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Document could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json([
                'error' => 1,
                'message' => 'Document with id ' . $id . ' not found'
            ], 400);
        }
        $document->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Document has been deleted'
        ]);
    }
}
