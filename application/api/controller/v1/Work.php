<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 18:02
 */

namespace app\api\controller\v1;

use app\model\Work as WorkModel;

class Work
{
    /**
     * 获取一份作品
     * @url /work/:id
     * @http GET
     */
    public function getWork($id){
        $work = WorkModel::get($id);
        return $work;
    }

    /**
     * 添加一张评分表
     * @url /work
     * @http POSTs
     */
    public function createWork(){
    }
}