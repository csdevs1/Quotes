<?php
$remove[] = "'";
$remove[] = '"';
$remove[] = '.';
$remove[] = "-"; // just as another example
/*
$profession="
On hold*
Military Officer*
Singer*
DJ*
Writer*
Author*
Novelist*
Commissioner of Baseball*
Poet*
Spiritual teacher*
Politician*
Basketball player*
Astronomer*
Editor*
Historian*
Film Actress*
Film Actor*
American football player*
Journalist*
Musician*
Biographer*
Activist*
Leader*
Playwright*
Composer*
songwriter*
Jurist*
Statistician*
Architect*
Painter*
Philosopher*
Game designer*
Sociologist*
Professional golfer*
Professor*
Curator*
Baseball player*
Former Vice President*
Former President*
Vice President*
President*
Rapper*
Businessman*
Pianist*
Biker*
Football player*
Photographer*
Chemist*
Television producer*
Visual Artist*
Entrepreneur*
Swimmer*
Athlete*
Film director*
Chef*
Screenwriter*
Computer programmer*
Psychiatrist*
Musical Artist*
Cricketer*
Model*
Hip-hop artist*
Diplomat*
Rabbi*
Inventor*
Priest*
Bishop*
Pope*
Cardinal*
Social Worker*
Sailor*
Prince*
King*
Queen*
Princess*
Critic*
Scientist*
Philanthropist*
Former Prime Minister*
Prime Minister*
Teacher*
Scholar*
Comedian*
Economist*
Film composer*
Secretary of State*
Columnist*
Philosopher*
Former First Lady*
First Lady*
Businesswoman*
Former Governor*
Governor*
Mathematician*
Reporter*
Lawyer*
Chief Rabbi*
manufacturer*
Tycoon*
Architectural Critic*
Countess*
Professional Boxer*
Monster truck driver*
Speechwriter*
Pastor*
Ice hockey player*
Racing driver*
Illustrator*
University Professor*
Guitarist*
Industrial designer*
Rugby Player*
Skater*
Figure skater*
Cryptographer*
Former Chancellor*
Chancellor*
Lyricist*
Basketball Coach*
American football Coach*
Football Coach*
Mogul*
Missionary*
Disc jockey*
Judge*
Runner*
Statistician*
Composer*
Saint*
Statesman*
Dramatist*
Filmmaker*
Banker*
Choreographer*
Martyr*
Essayist*
Tennis player*
Ballet Teacher*
Sportscaster*
Soldier*
Evangelist*
Cook*
Professional wrestler*
Emperor*
Pharaoh*
Boxer*
Chess Player*
Origamist*
Dancer*
Baseball Umpire*
Gangster*
Cartoonist*
Former Senator*
Senator*
Motivational speaker*
Trumpeter*
Magician*
Pimp*
Theologian*
Prose writer*
Surgeon*
Rock climber*
Philosopher of Science*
Exodus International*
Member of Parliament*
Radio host*
Software programmer*
Developer*
Referee*
Folklorist*
Doctor*
Engineer*
Commentator*
Audio Engineer*
Computer Scientist*
Naval Aviator*
Correspondent*
Surfer*
Bicycler*
Mobster*
Fighter*
Researcher*
Interior designer*
Botanist*
Military Commander*
Sculptor*
Attorney*
Pilot*
Runner*
Aviator*
Life peer*
Violinist*
Designer*
Mixed Martial Artist*
Manager*
Animator*
Biologist*
Former Emperor*
Emperor*
Chess master*
Penologist*
Educator*
Naturalist*
Ambassador*
Music Producer*
Former Ambassador*
Heir apparent*
Cosmonaut*
Host*
Geologist*
Stage Director*
Bridge Player*
Geneticist*
Tenor*
Islamic scholar*
Rashidun*
Supreme Leader*
Revolutionary*
Spokeswoman*
Billionaire*
Ballerina*
Business magnate*
Nurse*
Podcaster*
Software developer*
Director*
Pollster*
Talent manager*
Ballet Dancer*
Former Director of Central Intelligence*
Financier*
Ballet choreographer*
Graphic Designer*
Footballer*
Socialite*
Gymnast*
Presenter*
Creative consultant*
Blogger*
Youtuber*
Game designer*
Record producer*
Navigator*
Academic*
Cinematographer*
Futurist*
Mountaineer*
Winemaker*
Sculptor*
Nuclear Physicist*
Mayor*
Former  Mayor*
Landscape architect*
Literary agent*
Electrical engineer*
American football quarterback*
Archbishop*
Dean";*/

require_once 'AppClasses/AppController.php';
$obj = new AppController();
// ALTER TABLE authors ADD seo_url VARCHAR(255) after bio
$profession=explode("*",$profession);
$remove[] = "'";
$remove[] = '"';
$remove[] = '.';
$remove[] = "-"; // just as another example
sort($profession);
foreach($profession as $key=>$val){
    $list=$obj->find_by('professiones','professionName',$profession[$key]);
    if(empty($list)){
    $profession[$key][0]='';
        echo $obj->save('professions',"professionName",'"'.$profession[$key].'"').'<br>';
   }
}
?>