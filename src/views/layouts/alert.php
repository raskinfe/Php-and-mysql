<div class="alert-container">
    <p class="alert-error" id="error">
        <?php
            if(isset($error))
                echo "*** ".$error." ***";
        ?>
    </p>
    <p class="alert-success" id="success">
        <?php
        if(isset($success))
            echo "*** ".$success." ***";
        ?>
    </p>
</div>
