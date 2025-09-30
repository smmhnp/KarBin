<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'KarBin' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--import css-->
    @include('base.style')
</head>
<body>

    @include('base.nav')

    @yield('content')

    <!-- Footer (Persistent Layout Component) -->
    <footer style="text-align: center; padding: 30px 0; margin-top: 50px; border-top: 1px solid var(--border-color-light); color: var(--text-muted); font-size: 0.85rem;">
        سیستم مدیریت وظایف KarBin &copy; ۱۴۰۴ - تمامی حقوق محفوظ است.
    </footer>

    <!-- JavaScript for Tab Navigation and Filters -->
    @include('base.js')

 </body>
 </html>