<div class="min-vh-100 p-5 bg-light d-flex flex-column flex-wrap<?php if( ! $details): ?> justify-content-center align-items-center<?php endif; ?>">
    <h1><?= $pagetitle; ?></h1>
    <div><?= $html; ?></div>
    <div class="text-center">
        <a href="#" onclick="window.history.go(-1)" class="btn btn-secondary btn-rounded">Go Back</a>
    </div>
</div>

