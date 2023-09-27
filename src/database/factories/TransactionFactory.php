<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    private static $user_id = 0;
    private static $type = 0;
    private static $date = '2023-09-01';
    private static $flag = true;
    private static $days_count = 1;
    private static $time = '2023-09-01 00:00:00';
    private static $break = '+10';

    public function definition()
    {
        self::changeType();
        self::getTime();
        return [
            'user_id' => self::$user_id,
            'type' => self::$type,
            'time' => self::$time
        ];
    }

    private function changeType(){
        if(self::$flag){
            self::$user_id++;
            if(self::$user_id == 101){
                self::$user_id = 1;
                self::$date = date('Y-m-d', strtotime(self::$date .'+1day'));
                self::$days_count++;
                if(self::$days_count == 29){
                    self::$type++;
                    self:: $date = '2023-09-01';
                    self::$days_count = 1;
                    if(self::$type == 2){
                        self::$flag = false;
                        self::setBreak();
                    }
                }
            }
        }else{
            self::$type++;
            self::setBreak();
        }
    }

    private function setBreak(){
        switch(self::$type){
            case 2:
            case 4:
                self::$user_id = random_int(1,100);
                self::$date = $this->faker->dateTimeBetween('-26 day')->format('Y-m-d');
                self::$type = 2;
                break;
            case 3:
                break;
        }
    }

    private function getTime(){
        switch(self::$type){
            case 0:
                self::$time = date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('08:00:00', '10:00:00')->format('H:i:s')));
                break;
            case 1:
                self::$time = date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('18:00:00', '22:00:00')->format('H:i:s')));
                break;
            case 2:
                self::$time = date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('11:00:00', '16:00:00')->format('H:i:s')));
                break;
            case 3:
                self::$break = '+ '.strval(random_int(5,60)).'minute';
                self::$time = date('H:i:s', strtotime(self::$time.self::$break));
                self::$time = date('Y-m-d H:i:s',strtotime(self::$date.' '.self::$time));
                break;
        }
    }

}
