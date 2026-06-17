<?php get_header(); ?>

<svg style="display: none" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ico-eye" viewBox="0 0 24 24">
        <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
    </symbol>
    <symbol id="ico-play-btn-rounded" viewBox="0 0 17 17">
        <path fill="currentColor" d="M8.49961 0.849976C12.7246 0.849976 16.1496 4.275 16.1496 8.49998C16.1496 12.725 12.7246 16.15 8.49961 16.15C4.27463 16.15 0.849609 12.725 0.849609 8.49998C0.849609 4.275 4.27463 0.849976 8.49961 0.849976ZM8.49961 2.54998C5.21352 2.54998 2.54961 5.21388 2.54961 8.49998C2.54961 11.7861 5.21352 14.45 8.49961 14.45C11.7857 14.45 14.4496 11.7861 14.4496 8.49998C14.4496 5.21388 11.7857 2.54998 8.49961 2.54998ZM11.0496 8.49998L6.79961 11.05V5.94998L11.0496 8.49998Z"/>
    </symbol>
    <symbol id="ico-4k3" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.5 10.5H9V15H7.5v-1.5H5v-1.25l2.5-4.75H9v4.5h1.5v1.25zm5 1.5h-1.75l-1.75-2.25V15H10.5V9h1.5v2.25L13.75 9H15.5l-2.25 3 2.25 3zM9 12.25V10.5L7.85 12.25H9z"/>
    </symbol>
    <symbol id="ico-hd" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8 12H9.5v-2.5h-2V15H6V9h1.5v2.5h2V9H11v6zm5.5-1c0 .55-.45 1-1 1H12V9h2.5c.55 0 1 .45 1 1v4zm-1.5-1.5v-2h-1v2h1z"/>
    </symbol>
    <symbol id="ico-hd2" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8 12H9.5v-2.5h-2V15H6V9h1.5v2.5h2V9H11v6zm5.5-1c0 .55-.45 1-1 1H12V9h2.5c.55 0 1 .45 1 1v4zm-1.5-1.5v-2h-1v2h1z"/>
    </symbol>
    <symbol id="ico-sd2" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9.5 8c0 .55-.45 1-1 1H7v1h1.5c.55 0 1 .45 1 1V14c0 .55-.45 1-1 1H5.5v-1.5H7v-1H5.5V11c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v1zm7 2.5c0 .83-.67 1.5-1.5 1.5h-2.5V9h2.5c.83 0 1.5.67 1.5 1.5v3zm-1.5-2.5h-1v2h1v-2z"/>
    </symbol>
    <symbol id="ico-phone2" viewBox="0 0 24 24">
        <path fill="currentColor" d="M17 1H7c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm-5 20c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm5.25-3H6.75V4h10.5v14z"/>
    </symbol>
    <symbol id="ico-picture2" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
    </symbol>
    <symbol id="ico-wheel" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
    </symbol>
</svg>

<style>
    /* ==========================================================================
       VIP4K SINGLE VIDEO TEMPLATE OVERRIDES
       ========================================================================== */
    
    .single-video-page {
        background: var(--bg-primary);
        padding: 30px 0 60px;
    }

    .watch {
        position: relative;
        padding-bottom: 40px;
    }

    .watch__content {
        display: flex;
        align-items: start;
    }

    .watch__main {
        flex: 1 1 0%;
        min-width: 0;
    }

    .watch__side {
        width: 320px;
        flex-shrink: 0;
        margin-left: 28px;
    }

    /* ---- Video Player Overlay System ---- */
    .player-wrap {
        position: relative;
        width: 100%;
        background: #000;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(0,0,0,0.5);
    }

    .player-item__block {
        display: block;
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000;
    }

    .player-item__inner {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .player-item__inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Floating play button overlay */
    .player-poster-play {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background: rgba(0, 0, 0, 0.65);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.2s ease;
    }

    .player-poster-play:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background: rgba(0, 0, 0, 0.85);
        border-color: var(--accent-color);
    }

    .player-poster-play::after {
        content: "";
        border-style: solid;
        border-width: 15px 0 15px 25px;
        border-color: transparent transparent transparent #fff;
        margin-left: 6px;
    }

    /* Embedded Video elements initially overlayed */
    .player-item__block iframe,
    .player-item__block video {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border: none;
        z-index: 2;
    }

    /* ---- Video description metadata ---- */
    .player-description {
        position: relative;
        margin-top: 25px;
    }

    .player-description__info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .player-description__main {
        flex: 1 1 0%;
    }

    .player-description__title {
        font-family: var(--font-primary);
        font-size: 24px;
        font-weight: 800;
        line-height: 1.3;
        margin: 0 0 12px 0;
        color: #ffffff;
        letter-spacing: -0.4px;
    }

    .player-description__additional {
        display: block;
    }

    .player-additional {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        padding: 0;
        margin: 0;
        list-style: none;
        gap: 12px;
    }

    .player-additional__item {
        display: inline-flex;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        position: relative;
    }

    .player-additional__item:not(:last-child)::after {
        content: "";
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        margin-left: 12px;
        display: inline-block;
    }

    .player-additional__site {
        color: var(--accent-color);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .player-additional__site:hover {
        color: var(--accent-hover);
        text-decoration: underline;
    }

    .player-additional__icon {
        display: inline-flex;
        align-items: center;
        margin-right: 6px;
        color: var(--text-muted);
    }

    .player-additional__icon svg {
        width: 16px;
        height: 16px;
    }

    /* CTA Watch full video button */
    .player-description__button {
        flex-shrink: 0;
        margin-left: 20px;
    }

    .button--transparent-rounded {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 13px 28px;
        border-radius: 50px;
        border: 2px solid var(--accent-color);
        color: var(--accent-color);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12.5px;
        background: transparent;
        transition: var(--transition-fast);
        cursor: pointer;
    }

    .button--transparent-rounded:hover {
        background: var(--accent-color);
        color: #000;
        box-shadow: 0 4px 15px rgba(247, 0, 35, 0.35);
        transform: translateY(-2px);
    }

    .button--transparent-rounded svg {
        width: 16px;
        height: 16px;
    }

    /* Performer layout block */
    .player-description__about {
        padding-top: 22px;
    }

    .player-description__line {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .model {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 50px;
        padding: 6px 16px 6px 6px;
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .model:hover {
        background: rgba(247, 0, 35, 0.1);
        border-color: rgba(247, 0, 35, 0.3);
        transform: translateY(-2px);
    }

    .model__pic {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: #000;
        font-size: 13px;
        font-weight: 800;
    }

    .model__pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .model__name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-secondary);
        transition: color 0.2s ease;
    }

    .model:hover .model__name {
        color: var(--accent-color);
    }

    /* Tags inline block */
    .player-description__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tags__item {
        display: inline-block;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-secondary);
        padding: 6px 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        transition: var(--transition-fast);
    }

    .tags__item:hover {
        background: rgba(247, 0, 35, 0.12);
        border-color: rgba(247, 0, 35, 0.35);
        color: var(--accent-color);
        transform: translateY(-1px);
    }

    /* Description paragraph */
    .player-description__text {
        font-size: 14.5px;
        line-height: 1.7;
        color: #8c929a;
        margin: 20px 0 0;
    }

    /* Mobile Watch Button (hidden on desktop) */
    .player-item__button {
        display: none;
        margin: 20px 0;
        text-align: center;
    }

    .player-item__button .button--transparent-rounded {
        width: 100%;
        justify-content: center;
    }

    /* ---- Download Box layout ---- */
    .player-item__download {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.07);
    }

    .formats__title {
        font-size: 18px;
        font-weight: 800;
        text-transform: uppercase;
        color: #ffffff;
        margin-bottom: 20px;
        letter-spacing: 0.5px;
    }

    .formats__wrap {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .formats__item {
        display: block;
        text-decoration: none;
    }

    .formats__box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--bg-secondary);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 4px;
        padding: 20px;
        min-height: 130px;
        text-align: center;
        transition: var(--transition-fast);
    }

    .formats__item:hover .formats__box {
        border-color: rgba(247, 0, 35, 0.3);
        background: rgba(247, 0, 35, 0.03);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    .formats__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        margin-bottom: 12px;
        color: var(--text-secondary);
        transition: color 0.2s ease;
    }

    .formats__icon svg {
        width: 38px;
        height: 24px;
    }

    .formats__item:hover .formats__icon {
        color: var(--accent-color);
    }

    .formats__about {
        display: block;
    }

    .formats__name {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-secondary);
        text-transform: uppercase;
        margin-bottom: 4px;
        transition: color 0.2s ease;
    }

    .formats__item:hover .formats__name {
        color: #ffffff;
    }

    .formats__info {
        font-size: 11.5px;
        color: var(--text-muted);
    }

    /* ---- Sidebar / Banner block ---- */
    .sv-ad-wrap {
        background: var(--bg-secondary);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 290px;
    }

    .sv-ad-label {
        font-size: 9.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 14px;
        letter-spacing: 1px;
    }

    /* Actions panel row */
    .player-actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        color: #c0c8ce;
        font-size: 12.5px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 50px;
        cursor: pointer;
        transition: var(--transition-fast);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .action-btn.active-like {
        background: rgba(129, 189, 0, 0.12);
        border-color: rgba(129, 189, 0, 0.3);
        color: #81bd00;
    }

    .action-btn.active-dislike {
        background: rgba(231, 67, 74, 0.1);
        border-color: rgba(231, 67, 74, 0.22);
        color: #e7434a;
    }

    .action-btn.active-save {
        background: rgba(247, 0, 35, 0.1);
        border-color: rgba(247, 0, 35, 0.25);
        color: var(--accent-color);
    }

    /* ---- Toast popup ---- */
    .sv-toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--accent-color);
        color: #000;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 13.5px;
        z-index: 99999;
        box-shadow: 0 10px 30px rgba(247, 0, 35, 0.35);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .sv-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* ---- Comments Block styling ---- */
    .comments-wrapper {
        background: var(--bg-secondary);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 8px;
        padding: 25px;
        margin-top: 35px;
    }

    .comments-title-head {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .comments-wrapper #respond {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 6px;
        padding: 20px;
        margin-top: 20px;
    }

    .comments-wrapper #reply-title {
        color: #e0e8ee;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        text-transform: uppercase;
    }

    .comments-wrapper textarea,
    .comments-wrapper input[type="text"],
    .comments-wrapper input[type="email"] {
        width: 100%;
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border-radius: 4px;
        padding: 12px 14px;
        font-size: 13.5px;
        font-family: var(--font-primary);
        margin-bottom: 10px;
    }

    .comments-wrapper textarea:focus,
    .comments-wrapper input[type="text"]:focus,
    .comments-wrapper input[type="email"]:focus {
        border-color: rgba(247, 0, 35, 0.45) !important;
        outline: none;
    }

    .comments-wrapper .submit {
        background: var(--accent-color);
        color: #000;
        border: none;
        border-radius: 50px;
        padding: 10px 28px;
        font-weight: 800;
        cursor: pointer;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition-fast);
    }

    .comments-wrapper .submit:hover {
        background: var(--accent-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(247, 0, 35, 0.3);
    }

    .comment-list {
        list-style: none;
        padding: 0;
        margin: 20px 0 0 0;
    }

    .comment-body {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .comment-meta {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .comment-content {
        font-size: 13.5px;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    .comment-content p {
        margin-bottom: 0;
    }

    /* ---- Responsive break points ---- */
    @media screen and (max-width: 1280px) {
        .watch__content {
            display: block;
        }
        .watch__side {
            width: 100%;
            margin-left: 0;
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
    }

    @media screen and (max-width: 959px) {
        .player-description__button {
            display: none;
        }
        .player-item__button {
            display: block;
        }
    }

    @media screen and (max-width: 639px) {
        .single-video-page {
            padding-top: 15px;
        }
        .watch {
            padding-bottom: 20px;
        }
        .player-wrap {
            margin-left: -25px;
            margin-right: -25px;
            width: calc(100% + 50px);
            border-radius: 0;
        }
        .player-item__block {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
        }
        .player-description__title {
            font-size: 18px;
            line-height: 1.35;
        }
        .formats__wrap {
            grid-template-columns: 1fr;
        }
        .formats__box {
            min-height: 90px;
            flex-direction: row;
            justify-content: flex-start;
            padding: 12px 20px;
        }
        .formats__icon {
            margin-bottom: 0;
            margin-right: 20px;
        }
        .formats__about {
            text-align: left;
        }
    }
</style>

<div class="single-video-page">
    <div class="container">
        
        <div class="watch">
            <div class="watch__content">
                
                <!-- ============ MAIN VIDEO COLUMN ============ -->
                <div class="watch__main">
                    
                    <!-- Player Box -->
                    <div class="player-wrap">
                        <div class="player-item__block">
                            <?php
                            $iframe_url = get_post_meta(get_the_ID(), '_video_iframe_url', true);
                            $video_url  = get_post_meta(get_the_ID(), '_video_url', true);
                            $poster_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                            if (empty($poster_url) && has_post_thumbnail()) {
                                $poster_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            }
                            ?>
                            
                            <!-- Player elements (directly loaded) -->
                            <?php if (!empty($iframe_url)) : ?>
                                <iframe src="<?php echo esc_url($iframe_url); ?>" frameborder="0" allowfullscreen></iframe>
                            <?php elseif (!empty($video_url) && preg_match('/\.mp4$/i', $video_url)) : ?>
                                <video src="<?php echo esc_url($video_url); ?>" poster="<?php echo esc_url($poster_url); ?>" controls style="width:100%; height:100%; object-fit:contain;"></video>
                            <?php else : ?>
                                <div class="no-player-msg" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:2; background:#111; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#50585e;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                    <p style="font-size:14px; font-weight: 700;">Video not available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Video Details Block -->
                    <div class="player-item__description player-description">
                        
                        <div class="player-description__info">
                            <div class="player-description__main">
                                <h1 class="player-description__title"><?php the_title(); ?></h1>
                                <div class="player-description__additional">
                                    <ul class="player-additional">
                                        <?php
                                        $categories = get_the_terms(get_the_ID(), 'video_category');
                                        if ($categories && !is_wp_error($categories)) :
                                            $cat = $categories[0];
                                        ?>
                                            <li class="player-additional__item">
                                                <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="player-additional__site"><?php echo esc_html($cat->name); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="player-additional__item">
                                            <span class="player-additional__text"><?php echo get_the_date(); ?></span>
                                        </li>
                                        <li class="player-additional__item">
                                            <span class="player-additional__icon">
                                                <svg><use xlink:href="#ico-eye"></use></svg>
                                            </span>
                                            <span class="player-additional__text"><?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(1000, 9999)); ?> views</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <?php
                            $direct_link = get_option('_hexmy_ad_direct_link');
                            if (!empty($direct_link)) : ?>
                                <div class="player-description__button">
                                    <a class="button--transparent-rounded" href="#formats-download">
                                        <svg><use xlink:href="#ico-play-btn-rounded"></use></svg>
                                        <span>Watch full video</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Performers, Tags and Description -->
                        <div class="player-description__about">
                            <div class="player-description__line">
                                <?php
                                $pornstars = get_the_terms(get_the_ID(), 'pornstar');
                                if ($pornstars && !is_wp_error($pornstars)) :
                                    foreach ($pornstars as $star) :
                                        $star_link  = get_term_link($star);
                                        $star_image = get_term_meta($star->term_id, '_pornstar_image_url', true);
                                ?>
                                        <a href="<?php echo esc_url($star_link); ?>" class="player-description__model model">
                                            <div class="model__pic">
                                                <?php if (!empty($star_image)) : ?>
                                                    <img src="<?php echo esc_url($star_image); ?>" alt="<?php echo esc_attr($star->name); ?>" loading="lazy" referrerpolicy="no-referrer">
                                                <?php else : ?>
                                                    <?php echo strtoupper(substr($star->name, 0, 1)); ?>
                                                <?php endif; ?>
                                            </div>
                                            <span class="model__name"><?php echo esc_html($star->name); ?></span>
                                        </a>
                                <?php
                                    endforeach;
                                endif;
                                ?>

                                <!-- Tags list inline -->
                                <?php
                                $tags = get_the_terms(get_the_ID(), 'video_tag');
                                if ($tags && !is_wp_error($tags)) :
                                ?>
                                    <div class="player-description__tags">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="tags__item"><?php echo esc_html($tag->name); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content Description -->
                            <?php if (get_the_content()) : ?>
                                <div class="player-description__text"><?php the_content(); ?></div>
                            <?php endif; ?>
                        </div>

                    </div> <!-- .player-description -->

                    <!-- Mobile Watch Button CTA -->
                    <?php if (!empty($direct_link)) : ?>
                        <div class="player-item__button">
                            <a class="button--transparent-rounded" href="#formats-download">
                                <svg><use xlink:href="#ico-play-btn-rounded"></use></svg>
                                <span>Watch full video</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Action buttons (Like, Dislike, Share, Save) -->
                    <div class="player-actions-row">
                        <button class="action-btn" id="btn-like">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                            <span>Like</span>
                        </button>
                        <button class="action-btn" id="btn-dislike">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/></svg>
                            <span>Dislike</span>
                        </button>
                        <button class="action-btn" id="btn-share" onclick="copyShareLink()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            <span>Share</span>
                        </button>
                        <button class="action-btn" id="btn-save">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                            <span>Save</span>
                        </button>
                    </div>

                    <!-- Downloads Box -->
                    <?php if (!empty($direct_link)) : ?>
                        <div class="player-item__download new-video" id="formats-download">
                            <div class="formats">
                                <h2 class="formats__title">Download Resolutions</h2>
                                <div class="formats__wrap">
                                    <a class="formats__item" href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener">
                                        <div class="formats__box">
                                            <div class="formats__icon">
                                                <svg><use xlink:href="#ico-4k3"></use></svg>
                                            </div>
                                            <div class="formats__about">
                                                <div class="formats__name">4K - ULTRA HD</div>
                                                <div class="formats__info">MP4 format</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="formats__item" href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener">
                                        <div class="formats__box">
                                            <div class="formats__icon">
                                                <svg><use xlink:href="#ico-hd"></use></svg>
                                            </div>
                                            <div class="formats__about">
                                                <div class="formats__name">FHD MP4 - 1080p</div>
                                                <div class="formats__info">MP4 format</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="formats__item" href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener">
                                        <div class="formats__box">
                                            <div class="formats__icon">
                                                <svg><use xlink:href="#ico-hd2"></use></svg>
                                            </div>
                                            <div class="formats__about">
                                                <div class="formats__name">HD MP4 - 720p</div>
                                                <div class="formats__info">MP4 format</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="formats__item" href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener">
                                        <div class="formats__box">
                                            <div class="formats__icon">
                                                <svg><use xlink:href="#ico-phone2"></use></svg>
                                            </div>
                                            <div class="formats__about">
                                                <div class="formats__name">Mobile MP4 - 360p</div>
                                                <div class="formats__info">MP4 format</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="formats__item" href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener">
                                        <div class="formats__box">
                                            <div class="formats__icon">
                                                <svg><use xlink:href="#ico-picture2"></use></svg>
                                            </div>
                                            <div class="formats__about">
                                                <div class="formats__name">PHOTO GALLERY</div>
                                                <div class="formats__info">ZIP set</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Comments block -->
                    <div class="comments-wrapper">
                        <div class="comments-title-head">
                            <?php comments_number('No Comments', '1 Comment', '% Comments'); ?>
                        </div>
                        <?php comments_template(); ?>
                    </div>

                </div> <!-- .watch__main -->

                <!-- ============ SIDEBAR COLUMN ============ -->
                <?php
                $banner_code = get_option('_hexmy_ad_banner_300x250');
                if (!empty($banner_code)) :
                ?>
                    <div class="watch__side">
                        <div class="sv-ad-wrap">
                            <span class="sv-ad-label">Advertisement</span>
                            <div style="width:300px; max-width:100%; height:250px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                                <?php echo $banner_code; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div> <!-- .watch__content -->
        </div> <!-- .watch -->

        <!-- ============ RELATED VIDEOS GRID AT THE BOTTOM ============ -->
        <?php
        $tag_ids     = wp_get_post_terms(get_the_ID(), 'video_tag',  array('fields' => 'ids'));
        $star_ids    = wp_get_post_terms(get_the_ID(), 'pornstar',   array('fields' => 'ids'));
        $tax_query   = array('relation' => 'OR');
        if (!empty($tag_ids)) {
            $tax_query[] = array('taxonomy'=>'video_tag','field'=>'term_id','terms'=>$tag_ids,'operator'=>'IN');
        }
        if (!empty($star_ids)) {
            $tax_query[] = array('taxonomy'=>'pornstar','field'=>'term_id','terms'=>$star_ids,'operator'=>'IN');
        }
        $rel_args = array(
            'post_type'      => 'video',
            'posts_per_page' => 8,
            'post__not_in'   => array(get_the_ID()),
            'orderby'        => 'rand',
        );
        if (count($tax_query) > 1) {
            $rel_args['tax_query'] = $tax_query;
        }
        $related = new WP_Query($rel_args);
        if ($related->have_posts()) :
        ?>
            <section class="section" style="border-top: 1px solid rgba(255, 255, 255, 0.07); padding-top: 30px; margin-top: 10px;">
                <div class="section__block">
                    <div class="section__header" style="margin-bottom: 25px;">
                        <h2 class="section__title title title--grey" style="font-size: 18px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 0.5px;">Related Scenes</h2>
                    </div>
                    <div class="video-grid">
                        <?php
                        while ($related->have_posts()) : $related->the_post();
                            get_template_part('template-parts/video-card');
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div> <!-- .container -->
</div> <!-- .single-video-page -->

<!-- Share toast popup -->
<div class="sv-toast" id="share-toast">Link copied to clipboard!</div>

<script>
    // Copy URL helper
    function copyShareLink() {
        var dummy = document.createElement('input');
        dummy.value = window.location.href;
        document.body.appendChild(dummy);
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        
        var toast = document.getElementById('share-toast');
        if (toast) {
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 2200);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {


        // Action buttons rating behavior
        var btnLike    = document.getElementById('btn-like');
        var btnDislike = document.getElementById('btn-dislike');
        var btnSave    = document.getElementById('btn-save');

        if (btnLike && btnDislike) {
            btnLike.addEventListener('click', function() {
                btnLike.classList.toggle('active-like');
                btnDislike.classList.remove('active-dislike');
            });
            btnDislike.addEventListener('click', function() {
                btnDislike.classList.toggle('active-dislike');
                btnLike.classList.remove('active-like');
            });
        }

        if (btnSave) {
            btnSave.addEventListener('click', function() {
                btnSave.classList.toggle('active-save');
                var iconHtml = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>';
                btnSave.innerHTML = btnSave.classList.contains('active-save')
                    ? iconHtml + ' <span>Saved</span>'
                    : iconHtml + ' <span>Save</span>';
            });
        }
    });
</script>

<?php get_footer(); ?>
