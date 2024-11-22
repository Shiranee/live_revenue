<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // Example of a GET request
    public function getData()
    {
        $data = ['name' => 'John', 'age' => 30];
        return response()->json($data);  // Returns data as JSON
    }

    // Example of a POST request
    public function storeData(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
        ]);
        
        // Process the data (store, etc.)
        // Here, just return a success response
        return response()->json(['message' => 'Data received successfully!', 'data' => $validatedData]);
    }
}