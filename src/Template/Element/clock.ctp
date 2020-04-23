<div class="profile-nav alt">
    <section class="panel">
        <div class="user-heading alt clock-row terques-bg">
            <h1><?= date('l') . ', ' . date('d') ?></h1>
            <p class="text-left"><?= date('F') . ', ' .  date('Y') ?></p>
            <p class="text-left"><?= date('H:i') ?></p>
        </div>
        <ul id="clock">
            <li id="sec"></li>
            <li id="hour"></li>
            <li id="min"></li>
        </ul>
    </section>
</div>