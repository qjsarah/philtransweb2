<?php
session_start();
include 'config.php';

// Text fields
$fields = ['header1', 'paragraph1', 'apple_dl', 'google_dl', 'phone_img', 'header2', 'paragraph2', 'paragraph2_1', 'phone2_img', 'header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1', 'mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img', 'service_title', 'services_bgcolor', 'service_text', 'service_image', 'test_text', 'test_title', 'test_img', 'ads1', 'ads2', 'ads3', 'ads4', 'ads5', 'ads6', 'contact_title', 'email', 'number', 'loc', 'phone4_img', 'location_img', 'contact_img', 'web_img'];

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $content = $_POST[$field];

        // Decide which table and section to update based on $field
        if (in_array($field, ['header1', 'paragraph1','phone_img', 'apple_dl', 'google_dl'])) {
            $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#';
        }

        if (in_array($field, ['header2', 'paragraph2', 'paragraph2_1', 'phone2_img'])) {
            $stmt = $conn->prepare("UPDATE intro SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#intro';
        }
        if (in_array($field, ['header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1'])) {
            $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#about';
        }

        if (in_array($field, ['mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img'])) {
            $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#missionvission';
        }

        if (in_array($field, ['service_title', 'services_bgcolor', 'service_text', 'service_image'])) {
            $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#services';
        }

        if (in_array($field, ['test_text', 'test_title', 'test_img'])) {
            $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#testimonial';
        }

        if (in_array($field, ['ads1', 'ads2', 'ads3', 'ads4', 'ads5', 'ads6'])) {
            $stmt = $conn->prepare("UPDATE ads_section SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#testimonial';
        }
        if (in_array($field, ['contact_bg'])) {
            $content = $_POST[$field];
            $stmt = $conn->prepare("UPDATE cfs SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#contact';
        }
        if (in_array($field, ['contact_title', 'email', 'number', 'loc', 'phone4_img', 'location_img', 'contact_img', 'web_img'])) {
            $stmt = $conn->prepare("UPDATE contact SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#contact';
        }
    }
}

// Download Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['apple_dl', 'google_dl', 'phone_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'apple_dl' => ['dir' => '../../main/images/download_section/', 'path' => ''],
        'google_dl' => ['dir' => '../../main/images/download_section/', 'path' => ''],
        'phone_img' => ['dir' => '../../main/images/download_section/', 'path' => ''],
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Intro Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['phone2_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'phone2_img' => ['dir' => '../../main/images/download_section/', 'path' => '']
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE intro SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// About Us Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['tricycle_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'tricycle_img' => ['dir' => '../../main/images/about_section/', 'path' => '']
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Mission and Vision Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['mission_img', 'vision_img', 'phone3_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'mission_img' => ['dir' => '../../main/images/mission_and_vission_section/', 'path' => ''],
        'vision_img' => ['dir' => '../../main/images/mission_and_vission_section/', 'path' => ''],
        'phone3_img' => ['dir' => '../../main/images/mission_and_vission_section/', 'path' => '']
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Services Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['service_image'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'service_image' => ['dir' => '../../main/images/services_section/', 'path' => '']];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Testimonials Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['test_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'test_img' => ['dir' => '../../main/images/testimonial_section/', 'path' => '']];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Ads Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['ads1', 'ads2', 'ads3', 'ads4', 'ads5', 'ads6'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'ads1' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
        'ads2' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
        'ads3' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
        'ads4' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
        'ads5' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
        'ads6' => ['dir' => '../../main/images/ads_section/', 'path' => '']
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Redirection
if ($redirectSection) {
    header("Location: ../index.php{$redirectSection}");
    exit;
}