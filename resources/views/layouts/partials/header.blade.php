<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Langsa Single Sign On Dashboard</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .navbar-brand span {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .btn-logout {
            background-color: transparent;
            border: 1px solid #6c757d;
            color: #6c757d;
            font-weight: bold;
            border-radius: 5px;
            padding: 0.3rem 1rem;
            font-size: 0.9rem;
        }

        .btn-logout i {
            margin-right: 5px;
        }

        .welcome-section {
            background-color: #e6f4ea;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-section h2 {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .welcome-section p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0.5rem 0 0 0;
        }

        .welcome-section .btn {
            background-color: black;
            color: white;
            border-radius: 5px;
            padding: 0.3rem 1.5rem;
            font-size: 0.9rem;
        }

        .welcome-section img {
            width: 40px;
            height: 40px;
            margin-right: 1rem;
        }

        .sidebar {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .sidebar h5 {
            color: #28a745;
            font-weight: bold;
            background-color: #e6f4ea;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin: 0;
        }

        .sidebar .profile-section {
            text-align: center;
            margin: 1rem 0;
        }

        .sidebar .profile-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }

        .sidebar .profile-section p {
            margin: 0;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .sidebar .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .sidebar .info-item i {
            margin-right: 10px;
            color: #6c757d;
        }

        .sidebar .info-item span:last-child {
            margin-left: auto;
        }

        .app-card {
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-card .content {
            display: flex;
            align-items: center;
        }

        .app-card img {
            width: 40px;
            height: 40px;
            margin-right: 1rem;
        }

        .app-card h6 {
            font-weight: bold;
            margin: 0;
            font-size: 1rem;
        }

        .app-card p {
            color: #6c757d;
            font-size: 0.85rem;
            margin: 0.3rem 0 0 0;
        }

        .app-card .btn {
            background-color: transparent;
            border: 1px solid #28a745;
            color: #28a745;
            border-radius: 5px;
            padding: 0.3rem 1.5rem;
            font-size: 0.9rem;
        }

        .other-links {
            background-color: white;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .other-links i {
            margin-left: 5px;
        }
    </style>
</head>

<body>
