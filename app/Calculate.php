<?php

namespace App;
use Storage;
use File;
use Jenssegers\Mongodb\Model as Eloquent;

class Calculate extends Eloquent{
  
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

  public function scopePostsPerDay()
  {
    $outputArray = array();
    $outputArray['min'] = $this->MinPostsPerDay();
    $outputArray['max'] = $this->MaxPostsPerDay();
    $outputArray['average'] = $this->posts / $this->days;
    return $outputArray;
  }


  public function scopeMinPostsPerDay()
  {
    $lowest_post_count = array($this->dateArray[0] => count(array_keys($this->dateArray, $this->dateArray[0])));  
    foreach($this->dateArray as $date){
      $current_count =  count(array_keys($this->dateArray, $date));
      if ($current_count < reset($lowest_post_count)){
        $lowest_post_count = array($date => $current_count);
      } 
      elseif($current_count <= reset($lowest_post_count)){
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
      } 
      elseif($current_count >= reset($highest_post_count)){
        $highest_post_count[$date] = $current_count;
      }
    }
    return $highest_post_count;
  }


  public function scopePostMixPerDay()
  {
    $typeArray = array();
    foreach($this->data['data'] as $post){
      $type = $post['type'];
      array_push($typeArray, $type);
    }
    $typeArray = array_count_values($typeArray);
    foreach($typeArray as $k => &$v)
    {
      $v = $v / $this->posts;
    }
    return $typeArray;
  }

  public function scopeOrganicPostImpressions()
  {
    $impressionArray = array();
    $outputArray = array();
    foreach ($this->data['data'] as $post) {
      array_push($impressionArray, $post['insights']['data'][1]['values'][0]['value']);
    }
    
    $outputArray['min'] = min($impressionArray);
    $outputArray['max'] = max($impressionArray);
    $outputArray['average'] = array_sum($impressionArray) / count($impressionArray);

    return $outputArray;

  }

  public function scopePostCharacterCount()
  {
    $messageArray = array();
    $outputArray = array();
    foreach ($this->data['data'] as $post) {
      $messageLength = strlen(utf8_decode($post['message']));
      array_push($messageArray, $messageLength);
    }
    
    $outputArray['min'] = min($messageArray);
    $outputArray['max'] = max($messageArray);
    $outputArray['average'] = array_sum($messageArray) / count($messageArray);

    return $outputArray;

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
    return floor($datediff/(60*60*24)) + 1;
  }

  public function scopeRunner()
  {
    $outputArray = array();
    $outputArray['posts_per_day'] = $this->PostsPerDay();
    $outputArray['post_mix_per_day'] = $this->PostMixPerDay();
    $outputArray['organic_post_impressions'] = $this->OrganicPostImpressions();
    $outputArray['post_character_count'] = $this->PostCharacterCount();
    return $outputArray;
  }


}

