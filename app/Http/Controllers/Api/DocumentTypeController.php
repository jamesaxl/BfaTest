<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DocumentType;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $document_type = DocumentType::with('documentSubTypes')->get();
        return response()->json($document_type);
    }

    public function show($id)
    {
        $document_type = DocumentType::with('documentSubTypes')->find($id);
        if (!$document_type) {
            return response()->json([
                'error' => 1,
                'message' => 'Document-type with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $document_type ]);
    }
}
