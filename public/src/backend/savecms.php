<?php
session_start();
include 'config.php';

// Text fields
$fields = ['header1', 'paragraph1', 'apple_dl', 'google_dl', 'phone_img', 'header2', 'paragraph2', 'paragraph2_1', 'phone2_img', 'header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1', 'mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img', 'service_title', 'services_bg_color', 'service_text', 'service_image', 'test_text', 'test_title', 'test_img', 'ads1', 'ads2', 'ads3', 'ads4', 'ads5', 'ads6', 'contact_title', 'email', 'number', 'loc', 'phone4_img', 'location_img', 'contact_img', 'web_img', 'footer_copyright', 'footer_credits','download_bg_color','download_title_color','download_desc_color', 'intro_title_color','intro_desc_color', 'aboutus_title_color','aboutus_sub_color', 'aboutus_desc_color','mvision_bg_color','mission_font_color', 'vision_font_color',  'services_title_color','services_desc_color', 'card_title_color', 'card_desc_color',  'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color','test_bg_color', 'contact_bg_color', 'contact_title_color', 'contact_font_color', 'footer_bg_color', 'footer_font_color'];

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $content = $_POST[$field];

        // Decide which table and section to update based on $field
        if (in_array($field, ['header1', 'paragraph1','phone_img', 'apple_dl', 'google_dl','download_bg_color','download_title_color','download_desc_color'])) {
            $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#';
        }

        if (in_array($field, ['header2', 'paragraph2', 'paragraph2_1', 'phone2_img', 'intro_title_color','intro_desc_color'])) {
            $stmt = $conn->prepare("UPDATE intro SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#intro';
        }
        if (in_array($field, ['header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1', 'aboutus_title_color','aboutus_sub_color', 'aboutus_desc_color'])) {
            $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#about';
        }

        if (in_array($field, ['mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img', 'mvision_bg_color','mission_font_color', 'vision_font_color'])) {
            $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#missionvission';
        }

        if (in_array($field, ['service_title', 'services_bg_color', 'service_text', 'service_image','services_title_color','services_desc_color', 'card_title_color', 'card_desc_color'])) {
            $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#services';
        }

        if (in_array($field, ['test_text', 'test_title', 'test_img', 'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color', 'test_bg_color'])) {
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

        if (in_array($field, ['contact_title', 'email', 'number', 'location', 'phone4_img', 'location_img', 'contact_img', 'web_img', 'contact_bg_color', 'contact_title_color', 'contact_font_color'])) {
            $stmt = $conn->prepare("UPDATE contact SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#contact';
        }
        if (in_array($field, ['footer_copyright', 'footer_credits' , 'footer_bg_color', 'footer_font_color'])) {
            $stmt = $conn->prepare("UPDATE footer SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#footer';
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
    // Get the current image before updating
    $stmt = $conn->prepare("SELECT content FROM download WHERE key_name = ?");
    $stmt->bind_param("s", $cmsKey);
    $stmt->execute();
    $stmt->bind_result($oldImage);
    $stmt->fetch();
    $stmt->close();

    if ($oldImage) {
        // Archive old image into folder
        $archiveDir = '../../main/images/download_section/archive/';
        if (!is_dir($archiveDir)) {
            mkdir($archiveDir, 0777, true);
        }

        $oldPath = '../../main/images/download_section/' . basename($oldImage);
        $archivedName = time() . "_archived_" . basename($oldImage);
        $archivedPath = $archiveDir . $archivedName;

        if (file_exists($oldPath)) {
            if (rename($oldPath, $archivedPath)) {
                // Insert into archive DB
                $stmt = $conn->prepare("INSERT INTO download_archive (key_name, file_name) VALUES (?, ?)");
                $stmt->bind_param("ss", $cmsKey, $archivedName);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Update to new image
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
            'phone2_img' => ['dir' => '../../main/images/intro_section/', 'path' => '']
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
                // ✅ Step 1: Fetch current image before update
                $stmt = $conn->prepare("SELECT content FROM intro WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO intro_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update intro table with new file
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

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM aboutus WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO aboutus_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
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

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM missionvision WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO missionvision_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
        }
        }
    }
}

// About Us Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['service_image'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'service_image' => ['dir' => '../../main/images/services_section/', 'path' => '']
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

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM services WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO services_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}


// Testimonial Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['test_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'test_img' => ['dir' => '../../main/images/testimonial_section/', 'path' => '']
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

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM testimonial WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO testimonial_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
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
                $stmt = $conn->prepare("UPDATE ads_section SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Contact Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['phone4_img', 'location_img', 'contact_img', 'web_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'phone4_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        'location_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        'contact_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        'web_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
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

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM contact WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO contact_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE contact SET content = ? WHERE key_name = ?");
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