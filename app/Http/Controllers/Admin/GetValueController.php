<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\DocumentCategory;
use App\Models\Handicap;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\StructurePosition;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;

class GetValueController extends Controller
{
    public function getUserLevelDropdownValues()
    {
        $values = UserLevel::pluck('name', 'id');

        return response()->json($values);
    }

    public function getNewsCategoriesDropdownValues()
    {
        $values = NewsCategory::pluck('name', 'id');

        return response()->json($values);
    }

    public function getNewsTagsDropdownValues()
    {
        $values = NewsTag::pluck('name', 'id');

        return response()->json($values);
    }

    public function getNewsUserCreatedByDropdownValues()
    {
        $values = User::join('user_data', 'users.id', '=', 'user_data.user_id')->pluck('user_data.name', 'users.id');

        return response()->json($values);
    }

    public function getAthletesDropdownValues()
    {
        $values = Athlete::pluck('name', 'id');

        return response()->json($values);
    }

    public function getHandicapsDropdownValues()
    {
        $values = Handicap::pluck('name', 'id');

        return response()->json($values);
    }

    public function getDocumentCategoriesDropdownValues()
    {
        $values = DocumentCategory::pluck('name', 'id');

        return response()->json($values);
    }

    public function getStructurePositionsDropdownValues()
    {
        $values = StructurePosition::pluck('name', 'id');

        return response()->json($values);
    }
}
