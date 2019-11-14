<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 16:25
 */

namespace app\api\controller\v1;

use app\model\Sheet as SheetModel;

class Sheet
{
    /**
     * 获取一张评分表
     * @url /sheet/:id
     * @http GET
     */
    public function getSheet($id){
        $sheet = SheetModel::get($id);
        return $sheet;
    }

    /**
     * 创建一张评分表
     * @url /sheet
     * @http POST
     */
    public function createSheet(){
    }
}