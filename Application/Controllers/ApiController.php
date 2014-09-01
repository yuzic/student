<?php
/**
 * Created by JetBrains PhpStorm.
 * User: itcoder
 * Date: 06.10.13
 * Time: 21:48
 * To change this template use File | Settings | File Templates.
 */

class ApiController {

    public function getJsonData(){

    }

    public function actionInsert(){
        $dataArray = json_decode(Request::getPost('dataJson'), true);
        Loader::loadModel('Goods_Data');
        $goods = new Goods_Data(array(),
                                'goods_data');

        foreach ($dataArray as $data){
            $goods->_data = $data;
            $goods->save();
        }

    }

    public function actionUpdate(){
        $dataArray = json_decode(Request::getPost('dataJson'),
            true);
        Loader::loadModel('Goods_Data');
        $goods = new Goods_Data(array(),
            'goods_data');
        foreach ($dataArray as $data){
            $goods->keySet($data['id']);
            $goods->update($data);
        }
    }

    public function actionDelete(){
        $dataArray = json_decode(Request::getPost('dataJson'),
            true);
        Loader::loadModel('Goods_Data');
        $goods = new Goods_Data(array(),
                               'goods_data');
        foreach ($dataArray as $data){
            $goods->keySet($data['id']);
            $goods->delete();
        }




    }
}
