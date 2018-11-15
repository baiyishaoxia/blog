<?php

namespace App\Http\Model\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ArticleTmp extends Model
{
    protected $table = 'article_tmp';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    //region   新增活动logo图,存入id       tang
    public static function getArticleTmpBanner($data)
    {
        $res2 = true;
        if(isset($data['logo'])){
            if (count($data['logo']) >5){
                \DB::rollBack();
                return ['status'=>0,'info'=>'活动banner图不得超过5张'];
            }
            $res2 = ArticleTmpImages::created_files($data['logo']);
            $images_id=$res2;
        }else{
            $images_id = null;
        }
        $data['res'] = $res2;
        $data['images_id'] = $images_id;
        return $data;
    }
    //endregion

    //region   添加额外字段        tang
    public static function addTmpExtra($data,$model)
    {
        $list = [];
        if(isset($data['field'])){
            foreach ($data['field'] as $key=>$val){
                $list[$key]['user_id'] = User::info()['id'];
                $list[$key]['article_tmp_id'] = $model->id;
                $list[$key]['title'] = $val['title'];
                $list[$key]['is_required'] = isset($val['is_required'])?true:false;
                $list[$key]['field_type'] = $val['field_type'];
                $list[$key]['child'] = isset($val['value'])?json_encode($val['value']):'';
            }
        }
        return $list;
    }
    //endregion

    //region   修改额外字段        tang
    public static function editTmpExtra($data,$model)
    {
        $list = [];
        if(isset($data['field'])){
            foreach ($data['field'] as $key=>$val){
                //查询提交字段里数据库中是否存在
                if(isset($val['id']) && $val['id'] != ''){
                    //如果字段存在id,则表示数据库中存在,则修改
                    $res2 = ArticleTmpExtraField::where('user_id',User::info()['id'])->where('article_tmp_id',$model->id)->where('id',$val['id'])
                        ->update([
                            'title' => $val['title'],
                            'is_required' => isset($val['is_required'])?true:false,
                            'field_type' => $val['field_type'],
                            'child' => isset($val['value'])?json_encode($val['value']):''
                        ]);
                    if(!$res2){
                        \DB::rollBack();
                        return ['status'=>0,'info'=>'修改报名字段失败'];
                        break;
                    }
                }else{
                    //如果字段id等于空,则表示数据库中不存在,则新增
                    $list[$key]['user_id'] = User::info()['id'];
                    $list[$key]['article_tmp_id'] = $model->id;
                    $list[$key]['title'] = $val['title'];
                    $list[$key]['is_required'] = isset($val['is_required'])?true:false;
                    $list[$key]['field_type'] = $val['field_type'];
                    $list[$key]['child'] = isset($val['value'])?json_encode($val['value']):'';
                }
            }
        }
        return $list;
    }
    //endregion

    //region   模板        tang
    public static function select_template()
    {
        return [
            "1" => "水彩风1",
            "2" => "水彩风2",
            "3" => "简约风1",
            "5" => "简约风2",
            '4' => "自定义模板"
        ];
    }
    //endregion

    //region   获取多张logo图        tang
    public static function getArticleTmpBannerById($id){
        $cache_time = \Carbon\Carbon::now()->addMinutes(10);
        $data = \Cache::remember('getArticleTmpBanner:'.$id,$cache_time,function()use($id){
            $article_tmp = self::find($id);
            return ArticleTmpImages::get_file($article_tmp['logo']);
        });
        return $data;
    }
    //endregion

    //大赛模板(不允许随意修改,关联js) tang
    public static function getArticleTemplate($template_id)
    {
        $arr = "";
        switch ($template_id) {
            case 1:
                $arr = '活动模板1';
                break;
            case 2:
                $arr = '活动模板2';
                break;
            case 3:
                $arr = '活动模板3';
                break;
            case 5:
                $arr = '活动模板4';
                break;
            case 4:
                $arr = '自定义模板';
                break;
            default:
                $arr = '暂未选择模板';
                break;
        }
        return $arr;
    }
    //endregion
}
