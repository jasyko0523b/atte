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

    private static int $user_id = 1;
    private static int $type = 0;
    private static $date = '2023-09-20';

    public function definition()
    {
        self::changeUser();
        return [
            'user_id' => self::$user_id,
            'type' => self::$type++,
            'time' => self::getTime()
        ];
    }

    private function changeUser(){
        if(self::$type == 4){
            self::$user_id = random_int(1,100);
            self::$type = 0;
            self::$date = $this->faker->dateTimeBetween('-1 week')->format('Y-m-d');
        }
    }

    private function getTime(){
        switch(self::$type){
            case 1:
                return date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('08:00:00', '10:00:00')->format('H:i:s')));
            case 2:
                return date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('18:00:00', '22:00:00')->format('H:i:s')));
            case 3:
                return date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('11:00:00', '14:00:00')->format('H:i:s')));
            case 4:
                return date('Y-m-d H:i:s',strtotime(self::$date.' '.$this->faker->dateTimeBetween('15:00:00', '17:00:00')->format('H:i:s')));
        }
    }

}
