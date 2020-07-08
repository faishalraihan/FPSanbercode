<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $table = 'answers';
    protected $fillable = ['content','uploader_id', 'question_id'];

    /**
     * Function to get the number of votes
     * an answer has
     * 
     * @return int
     */
    public static function count_votes($id){
        $answer = Answer::where('id', $id)->get()[0];
        $votes = count($answer->votes);
        return $votes;
    }

    /**
     * Function to vote the answer
     * 
     * @return void
     */
    public static function vote($userid, $answerid, $value){
        AnswerVote::updateOrCreate([
            'voter_id'=>$userid,
            'answer_id'=>$answerid,
            'value'=>$value
        ]);
    }

    /** RELATIONSIHPS */
    public function uploader(){
        return $this->belongsTo('App\User', 'uploader_id');
    }
    public function question(){
        return $this->belongsTo('App\Question', 'question_id');
    }
    public function _question(){
        return $this->hasOne('App\Question', 'best_answer_id');
    }
    public function comments(){
        return $this->hasMany('App\AnswerComment');
    }
    public function votes(){
        return $this->hasMany('App\AnswerVote');
    }
}
