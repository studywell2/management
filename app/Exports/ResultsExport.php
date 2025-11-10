<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::all(); // fetch results
        return view('results.index', compact('results')); // pass to a view
    }

    public function export()
    {
        $results = Result::all()->toArray();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=results.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        if(count($results) > 0) {
            echo "<tr>";
            foreach(array_keys($results[0]) as $header) {
                echo "<th>" . htmlspecialchars($header) . "</th>";
            }
            echo "</tr>";

            foreach($results as $row) {
                echo "<tr>";
                foreach($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No results found</td></tr>";
        }
        echo "</table>";
        exit;
    }
}
