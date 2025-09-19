
<!DOCTYPE html>
<html lang="en" class="dyslexia-mode">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Platform | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=OpenDyslexic:wght@400;700&family=Comic+Neue:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.cdnfonts.com/css/opendyslexic" rel="stylesheet">
    <style>
    :root {
        --primary: #4F46E5;
        --secondary: #10B981;
        --dyslexia-bg: #F9F5FF;
        --dyslexia-text: #1F2937;
    }

    body {
        font-family: 'Comic Neue', 'OpenDyslexic', sans-serif;
        line-height: 1.6;
        letter-spacing: 0.05em;
        color: var(--dyslexia-text);
        background-color: var(--dyslexia-bg);
    }

    .dyslexia-mode {
        font-family: 'Comic Neue', 'OpenDyslexic', sans-serif;
    }

    .dyslexia-text {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .progress-ring__circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }

    .sidebar {
        background-color: #FFFFFF;
        border-right: 1px solid #E5E7EB;
    }

    .sidebar-item {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin: 0.25rem 0;
    }

    .sidebar-item:hover {
        background-color: #EDE9FE;
        transform: translateX(4px);
    }

    .sidebar-item.active {
        background-color: #E0E7FF;
        color: #4F46E5;
        font-weight: 600;
    }

    .sidebar-icon {
        width: 24px;
        height: 24px;
        margin-right: 12px;
    }

   

    .readable-font {
        font-size: 1.1rem;
        line-height: 1.8;
    }

        /* Fixed upcoming tasks section */
    .task-item {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem;
        transition: background-color 0.2s ease;
    }

    .task-item:hover {
        background-color: #f9fafb;
    }

    .task-icon {
        flex-shrink: 0;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .task-content {
        flex: 1;
        min-width: 0;
    }

    .task-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }

    .task-meta {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .task-meta svg {
        margin-right: 0.25rem;
    }
    .dyslexia-mode {
    font-family: 'OpenDyslexic', Arial, sans-serif !important;
    line-height: 1.8;
    letter-spacing: 0.05em;
    background-color: #fafafa;
    color: #222;
  }

  .tts-button {
    margin-top: 8px;
    padding: 6px 10px;
    font-size: 0.9rem;
    border-radius: 6px;
    background: #4f46e5;
    color: #fff;
    cursor: pointer;
  }

  .tts-button:hover {
    background: #3730a3;
  }
    </style>
</head>
