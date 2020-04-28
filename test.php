<?php



/*
 * Complete the 'goodSegment' function below.
 *
 * The function is expected to return an INTEGER.
 * The function accepts following parameters:
 *  1. INTEGER_ARRAY badNumbers
 *  2. INTEGER l
 *  3. INTEGER r
 */

function test($badNumbers, $i){
    $last = $i%10;
        $sum = $last;
        if($last == $badNumbers){
            return false;
        }
        $i = (int)($i/10);
        while($i){
            $last = $i%10;
            if($last == $badNumbers || $last <= $sum){
                return false;
            }else{
                $sum += $last;
                $i = (int)($i/10);
            }
        }
        return true;

}
function goodSegment($badNumbers, $l, $r) {
    // Write your code here
    for($i = $l; $i <= $r; $i++){
        foreach($badNumbers as $badNumber){
            if(test($badNumber, $i)){
            echo $i;
            }
        }
        
    }

}

goodSegment([4,5,4,2,15],1, 10);
?>