<?php if(isExamLive($exam->start_at, $exam->end_at)) : ?>
    <span class="text-blue">LIVE</span>
<?php else : ?>
    <span class="text-muted">UNALIVE</span>
<?php endif; ?>