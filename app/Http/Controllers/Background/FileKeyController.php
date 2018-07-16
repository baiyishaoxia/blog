<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Http\Model\Background\FileKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class FileKeyController extends Controller
{
    //region   显示        tang
    public function getSetKey($file_id)
    {
        $data = FileKey::where('file_id', $file_id)->get();
        return view('background.file.set_key', compact('data', 'file_id'));
    }
    //endregion

    //region   配置        tang
    public function postSetKey(Request $request)
    {
        try {
            if (!$request->has('data')) {
                return back()->withErrors("最少有一个参数");
            }
            FileKey::where('file_id', $request->get('file_id'))->delete();
            $data = $request->get('data');
            $data = array_values($data);
            $data = ArrayTools::arrayAddElement($data, 'file_id', $request->get('file_id'));
            if (FileKey::insert($data)) {
                return redirect(\URL::action('Background\FileController@getList'))->withErrors("配置成功");
            } else {
                return back()->withErrors("配置失败");
            }
        } catch (\Exception $e) {
            return back()->withErrors("操作异常");
        }
    }
    //endregion
}
