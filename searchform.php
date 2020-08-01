<?php 
    // esc_url() Checks and cleans a URL for security reason
    // This will protect the user of your site if your site has already been hacked or compromised
    // If one of your admin of the website has gone rouge
?>

<form method="GET" action="<?php echo esc_url(site_url('/')); ?>" class="search-form">
    <label class="headline headline--medium" for="s">Perform a new Search</label>
    <div class="search-form-row">
        <input type="search" name="s" class="s" id="s" placeholder="What are you looking for...?">
        <input type="submit" value="Search" class="search-submit">
    </div>
</form>