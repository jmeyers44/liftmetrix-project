<?php

namespace App;
use Storage;
use File;
use Jenssegers\Mongodb\Model as Eloquent;

class Page extends Eloquent{
    //
  protected $connection = 'mongodb';

    public function __construct() {
      $this->data = $this->GetData();
      $this->posts = $this->TotalPosts();
      $this->days = $this->TotalDays();
      $this->dateArray = $this->PostDateArray();
    }

      public function scopeGetData()
    {
        $userJson = Storage::get('jonathan_test.json');
        $userJson = json_decode($userJson, true);
        return $userJson;   
    }

    public function scopeAveragePostsPerDay()
    {
      return $this->posts / $this->days;
    }

    public function scopeMinPostsPerDay()
    {
       $lowest_post_count = array($this->dateArray[0] => count(array_keys($this->dateArray, $this->dateArray[0])));  
       foreach($this->dateArray as $date){
        $current_count =  count(array_keys($this->dateArray, $date));
        if ($current_count < reset($lowest_post_count)){
          $lowest_post_count = array($date => $current_count);
        } elseif($current_count <= reset($lowest_post_count)){
          $lowest_post_count[$date] = $current_count;
        }
       }
       return $lowest_post_count;
    }

        public function scopeMaxPostsPerDay()
    {
       $highest_post_count = array($this->dateArray[0] => count(array_keys($this->dateArray, $this->dateArray[0])));  
       foreach($this->dateArray as $date){
        $current_count =  count(array_keys($this->dateArray, $date));
        if ($current_count > reset($highest_post_count)){
          $highest_post_count = array($date => $current_count);
        } elseif($current_count >= reset($highest_post_count)){
          $highest_post_count[$date] = $current_count;
        }
       }
       return $highest_post_count;
    }

    public function scopePostDateArray()
    {
      $dateArray = array();
      foreach($this->data['data'] as $post){
        $datetime = $post['created_time'];
        $date = date('Y-m-d', strtotime($datetime));
        array_push($dateArray, $date);
      }
      return $dateArray;

    }

    public function scopeTotalPosts()
    {
      $totalPosts = $this->data['data'];
      return count($totalPosts);
    }

    public function scopeTotalDays()
    {
      $lastitem = $this->posts - 1;
      $date1 = strtotime($this->data['data'][0]['created_time']);
      $date2 = strtotime($this->data['data'][$lastitem]['created_time']);
      $datediff = $date1 - $date2;
      return floor($datediff/(60*60*24));
    }
}
