<div class="content">
    <h3>Autenticação</h3>

    <?php
    echo $this->Form->create();
    echo $this->Form->control('username');
    echo $this->Form->control('password');
    echo $this->Form->button('Logar');
    echo $this->Form->end();
    ?>
</div>