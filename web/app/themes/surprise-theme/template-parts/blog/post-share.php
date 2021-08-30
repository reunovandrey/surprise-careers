<div class="post-share">  
  <ul class="post-share-list">
    <li><span class="post-share-label"><?php _e('Share', 'surprise'); ?></span></li>
    <li>
      <a href="https://www.facebook.com/sharer/sharer.php?display=page&u=<?php echo $url; ?>&p[images][0]=<?php echo $media;?>&p[title]=<?php echo $title; ?>" target="_blank" aria-label="Facebook" rel="noreferrer noopener">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#2E77F2"/><path d="M25.0098 21.25L25.5653 17.6305H22.0922V15.2816C22.0922 14.2914 22.5774 13.3262 24.1329 13.3262H25.7118V10.2445C25.7118 10.2445 24.279 10 22.909 10C20.0489 10 18.1794 11.7336 18.1794 14.8719V17.6305H15.0001V21.25H18.1794V30H22.0922V21.25H25.0098Z" fill="white"/></svg>
      </a>
    </li>

    <li>
      <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" aria-label="Tweeter" rel="noreferrer noopener">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#3291DA"/><path d="M27.9442 16.0482C27.9569 16.2259 27.9569 16.4036 27.9569 16.5812C27.9569 22 23.8326 28.2437 16.2944 28.2437C13.9721 28.2437 11.8147 27.5711 10 26.4036C10.33 26.4417 10.6472 26.4544 10.9898 26.4544C12.9061 26.4544 14.6701 25.8072 16.0787 24.7031C14.2767 24.665 12.7665 23.4848 12.2462 21.8604C12.5 21.8985 12.7538 21.9239 13.0203 21.9239C13.3883 21.9239 13.7564 21.8731 14.099 21.7843C12.2208 21.4036 10.8122 19.7538 10.8122 17.7614V17.7107C11.3578 18.0153 11.9924 18.2056 12.6649 18.231C11.5609 17.4949 10.8375 16.2386 10.8375 14.8172C10.8375 14.0558 11.0406 13.3579 11.3959 12.7487C13.4137 15.236 16.4467 16.8604 19.8477 17.0381C19.7843 16.7335 19.7462 16.4163 19.7462 16.099C19.7462 13.8401 21.5736 12 23.8452 12C25.0254 12 26.0914 12.4949 26.8401 13.2944C27.7665 13.1168 28.6548 12.7741 29.4416 12.3046C29.137 13.2564 28.4898 14.0559 27.6396 14.5634C28.4645 14.4747 29.264 14.2462 30 13.929C29.4417 14.7411 28.7437 15.4644 27.9442 16.0482Z" fill="white"/></svg>
      </a>
    </li>

    <li>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>" target="_blank" aria-label="Linkedin" rel="noreferrer noopener">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#2466C2"/><path d="M14.4768 30H10.3304V16.647H14.4768V30ZM12.4013 14.8256C11.0754 14.8256 10 13.7273 10 12.4014C10 11.7645 10.253 11.1537 10.7033 10.7034C11.1537 10.253 11.7645 10 12.4013 10C13.0382 10 13.649 10.253 14.0993 10.7034C14.5497 11.1537 14.8027 11.7645 14.8027 12.4014C14.8027 13.7273 13.7268 14.8256 12.4013 14.8256ZM29.9955 30H25.858V23.4999C25.858 21.9507 25.8268 19.9641 23.7022 19.9641C21.5464 19.9641 21.2161 21.6471 21.2161 23.3882V30H17.0741V16.647H21.0509V18.4685H21.1089C21.6625 17.4194 23.0147 16.3122 25.0321 16.3122C29.2286 16.3122 30 19.0756 30 22.665V30H29.9955Z" fill="white"/></svg>
      </a>
    </li>

    <li>
      <a href="mailto:?&subject=<?php echo $title; ?>&cc=&bcc=&body=<?php echo $url; ?>" target="_blank" aria-label="Linkedin" rel="noreferrer noopener">
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="16" fill="#222222"/><path d="M21.5999 10H10.3999C9.76336 10 9.15291 10.2529 8.70282 10.7029C8.25273 11.153 7.99988 11.7635 7.99988 12.4V20.4C7.99988 21.0365 8.25273 21.647 8.70282 22.0971C9.15291 22.5471 9.76336 22.8 10.3999 22.8H21.5999C22.2364 22.8 22.8468 22.5471 23.2969 22.0971C23.747 21.647 23.9999 21.0365 23.9999 20.4V12.4C23.9999 11.7635 23.747 11.153 23.2969 10.7029C22.8468 10.2529 22.2364 10 21.5999 10ZM21.2719 11.6L16.5679 16.304C16.4935 16.379 16.405 16.4385 16.3075 16.4791C16.2101 16.5197 16.1055 16.5406 15.9999 16.5406C15.8943 16.5406 15.7897 16.5197 15.6922 16.4791C15.5947 16.4385 15.5062 16.379 15.4319 16.304L10.7279 11.6H21.2719ZM22.3999 20.4C22.3999 20.6122 22.3156 20.8157 22.1656 20.9657C22.0155 21.1157 21.8121 21.2 21.5999 21.2H10.3999C10.1877 21.2 9.98422 21.1157 9.83419 20.9657C9.68416 20.8157 9.59988 20.6122 9.59988 20.4V12.728L14.3039 17.432C14.7539 17.8814 15.3639 18.1339 15.9999 18.1339C16.6359 18.1339 17.2459 17.8814 17.6959 17.432L22.3999 12.728V20.4Z" fill="white"/></svg>
      </a>
    </li>

  </ul>
</div><!-- .post-share -->