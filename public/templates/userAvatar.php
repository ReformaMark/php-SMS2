<div class=" flex items-center gap-x-3">
    <div class= "h-8 w-8 p-2">
        <svg class="text-gray-500 size-4" id="Layer_1_1_" style="enable-background:new 0 0 16 16;" version="1.1" viewBox="0 0 16 16" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M13,5c0-2.761-2.239-5-5-5S3,2.239,3,5v5l-3,2v1h16v-1l-3-2V5z"/><path d="M10,14H6c0,1.105,0.895,2,2,2S10,15.105,10,14z"/></svg>
    </div>
    
    <div class= "border-black border rounded-full h-8 w-8 p-2">
        <svg class="feather feather-user text-gray-500 size-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </div>
    
    <?php echo '<h1 class="font-medium text-sm uppercase">' . $_SESSION['user_username'] . '</h1>' ?>
</div>