<input type="hidden" name="count" value="<?php echo $productOptionsactivateLoadMore == "on" ? 2 : count($catalogProducts); ?>">
<input type="text" placeholder="<?php echo $searchFieldPlaceholderText?>" ns="<?php echo $ns; ?>" page="<?php echo $loadMoreDefaultImagesCount; ?>" name="productOptionsEnableSearch"/>
<button type="submit" value="search" ns="<?php echo $ns; ?>" page="<?php echo $loadMoreDefaultImagesCount; ?>" name="productOptionsEnableSearchBtn" id="productOptionsEnableSearchBtn">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512" enable-background="new 0 0 512 512" width="13px" height="13px">
        <g>
            <path d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5 S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9   C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z" fill="#303030"/>
        </g>
    </svg>
</button>