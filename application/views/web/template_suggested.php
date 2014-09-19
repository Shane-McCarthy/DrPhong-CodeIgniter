<?php if (!empty($tracks)): ?>
    <?php $curlink = 1; ?>
    <?php foreach ($tracks as $key => $track): ?>
         <?php echo $track->username; ?>
        <?PHP echo $track->track; ?>
      
 <?php endforeach; ?>                      
<?php endif; ?>
