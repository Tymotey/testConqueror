<h1 id="page_title">All challenges</h1>

<?php
    $items = get_challenges();

    if($items['error'] === true){
        echo '<h3>' . $items['message'] . '</h3>';
    }
    else{
?>
    <div class="list_toolbar">
        <div class="sort_div">
            <span class="label">Sort by:</span><select class="sort_select">
                <option value="by-popularity-asc">Popular Asc</option>
                <option value="by-popularity-desc" selected>Popular Desc</option>
                <option value="by-name-asc">Name Asc</option>
                <option value="by-name-desc">Name Desc</option>
            </select>
        </div>
    </div>
    <div id="challenges_list">
        <?php
            foreach($items['data'] as $challenge){
                $html = get_list_challenge($challenge);
                if($html !== '') echo $html;
            }
        ?>
    </div>
<?php
    }
?>