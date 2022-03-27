
<div class="form-panel">
    <h2 class="title"><?php echo __('Arrival Time','eagle-booking') ?></h2>
        <div class="eb-arrival-slots">

        <?php

            $eb_arrival_slots = eb_get_option('arrival_slots');

            if ( $eb_arrival_slots ) foreach ( $eb_arrival_slots as $eb_arrival_slot ) {

                echo '<div class="time-slot eb-radio-box">';
                echo '<input type="radio" name="eb_user_arrival" id="'.str_replace(" ","",$eb_arrival_slot).'" value="'.$eb_arrival_slot.'">';
                echo '<label for="'.str_replace(" ","",$eb_arrival_slot).'" >' . $eb_arrival_slot . '</label>';
                echo '</div>';

            }

        ?>

    </div>
</div>