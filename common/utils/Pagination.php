<?php

namespace common\utils;

class Pagination{
    public static function data
    (
        $params=[
            'current'=>1,
            'total'=>1,
        ],
        $side=[
            'left'=>1,
            'right'=>1,
        ]
    ){
        $result=['arr'=>[],'btn'=>['first'=>false,'last'=>false]];
        
        if($params['total']<=($side['left']+$side['right']+1)){
            for($i=1;$i<=$params['total'];$i++){
                $result['arr'][]=$i;
            }            
        }
        elseif($params['current']<=$side['left']+1){
            for($i=1;$i<=$side['left']+$side['right']+1;$i++){
                $result['arr'][]=$i;
            }
            $result['btn']['last']=true;
        }
        elseif($params['current']<($params['total']-$side['right'])){
            for($i=$params['current']-$side['left'];$i<=$params['current']+$side['right'];$i++){
                $result['arr'][]=$i;
            }
            $result['btn']['first']=true;
            $result['btn']['last']=true;
        }
        else{
            for($i=$params['total']-$side['left']-$side['right'];$i<=$params['total'];$i++){
                $result['arr'][]=$i;
            }
            $result['btn']['first']=true;
        }
        
        return $result;
    }

}