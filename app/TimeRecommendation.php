<?php

namespace App;
use Storage;
use File;
use Jenssegers\Mongodb\Model as Eloquent;

class TimeRecommendation extends Eloquent{

  public function __construct() 
  {
    $this->data = $this->GetData();
    $this->posts = $this->TotalPosts();
    $this->days = $this->TotalDays();
    $this->sortedData = $this->ParsePosts();
    $this->hourlyTotals = $this->TotalByHour();
  }

  public function scopeGetData()
  {
    $userJson = Storage::get('jonathan_test.json');
    $userJson = json_decode($userJson, true);
    return $userJson;   
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

  public function scopeHighestAverage()
  {
    $highest_average = array('hour' => 0, 'average_impressions' => 0);
    foreach($this->hourlyTotals as $hour => $values){
      $impressions = $values['impressions'];
      $postCount = $values['post_count'];
      $average = $impressions / $postCount;
      if($average > $highest_average['average_impressions']){
        $highest_average['hour'] = $hour;
        $highest_average['average_impressions'] = $average;
      }
    }
    return $highest_average;
  }

  public function scopeTotalByHour()
  {
    $highest_unpaid_average = array();
    // can change unpaid to paid
    foreach($this->sortedData['unpaid'] as $day => $time){
      foreach($time as $hour => $counts){
        $postCount = $counts['post_count'];
        $impressionCount = $counts['impressions']['lifetime_organic_impressions'];
        $postCount = $counts['post_count'];
        if(array_key_exists($hour, $highest_unpaid_average)){
          $highest_unpaid_average[$hour]['impressions'] += $impressionCount;
          $highest_unpaid_average[$hour]['post_count'] += $postCount;
        }else{
          $highest_unpaid_average[$hour] = array('impressions' => $impressionCount, 'post_count' => $postCount);
        }
      }
    }
    return $highest_unpaid_average;
  }

  public function scopeParsePosts()
  {
    $postTimeImpressionArray = array('paid' => [], 'unpaid' => []);
    foreach($this->data['data'] as $post){
      $this->currentPost = $post;
      $timeDayArray = $this->ExtractTime();
      $day = $timeDayArray[0];
      $time = $timeDayArray[1];
      $impressionArray = $this->ExtractImpressions();
      if($impressionArray['lifetime_paid_impressions'] == 0){
      if(array_key_exists($day, $postTimeImpressionArray['unpaid']) && array_key_exists($time, $postTimeImpressionArray['unpaid'][$day])){
        $postTimeImpressionArray['unpaid'][$day][$time]['impressions']['lifetime_impressions'] += $impressionArray['lifetime_impressions'];
        $postTimeImpressionArray['unpaid'][$day][$time]['impressions']['lifetime_organic_impressions'] += $impressionArray['lifetime_organic_impressions'];
        $postTimeImpressionArray['unpaid'][$day][$time]['impressions']['lifetime_paid_impressions'] += $impressionArray['lifetime_paid_impressions'];
        $postTimeImpressionArray['unpaid'][$day][$time]['post_count'] += 1;
      }
      else{
        $postTimeImpressionArray['unpaid'][$day][$time]['impressions'] = $impressionArray;
        $postTimeImpressionArray['unpaid'][$day][$time]['post_count'] = 1;
      }
      }else{
        if(array_key_exists($day, $postTimeImpressionArray['paid']) && array_key_exists($time, $postTimeImpressionArray['paid'][$day])){
        $postTimeImpressionArray['paid'][$day][$time]['impressions']['lifetime_impressions'] += $impressionArray['lifetime_impressions'];
        $postTimeImpressionArray['paid'][$day][$time]['impressions']['lifetime_organic_impressions'] += $impressionArray['lifetime_organic_impressions'];
        $postTimeImpressionArray['paid'][$day][$time]['impressions']['lifetime_paid_impressions'] += $impressionArray['lifetime_paid_impressions'];
        $postTimeImpressionArray['paid'][$day][$time]['post_count'] += 1;
      }
      else{
        $postTimeImpressionArray['paid'][$day][$time]['impressions'] = $impressionArray;
        $postTimeImpressionArray['paid'][$day][$time]['post_count'] = 1;
      }
      }
    }
    return $postTimeImpressionArray;
  }

  public function scopeExtractTime()
  {
    $post = $this->currentPost;
    $time = $post['created_time'];
    $dateTimeArray = explode(',', date('D,G', strtotime($time)));
    return $dateTimeArray;
  }

  public function scopeExtractImpressions()
  {
    $post = $this->currentPost;
    $outputArray = array();
    $outputArray['lifetime_impressions'] = $post['insights']['data'][0]['values'][0]['value'];
    $outputArray['lifetime_organic_impressions'] = $post['insights']['data'][1]['values'][0]['value'];
    $outputArray['lifetime_paid_impressions'] = $post['insights']['data'][2]['values'][0]['value'];
    return $outputArray;
  }
}
