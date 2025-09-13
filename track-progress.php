<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); 
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

include_once 'inc/database.php';

$userId   = $_SESSION['id'];
$lessonId = $_POST['lessonId'] ?? null;
$courseId = $_POST['courseId'] ?? null;

if ($lessonId && $courseId) {
    // Check if already exists
    $checkSql = "SELECT COUNT(*) FROM progress WHERE userId = :userId AND courseId = :courseId AND lessonId = :lessonId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        'userId'   => $userId,
        'courseId' => $courseId,
        'lessonId' => $lessonId
    ]);

    if ($checkStmt->fetchColumn() == 0) {
        // Insert if not found
        $sql = "INSERT INTO progress (userId, courseId, lessonId) 
                VALUES (:userId, :courseId, :lessonId)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'userId'   => $userId,
            'courseId' => $courseId,
            'lessonId' => $lessonId
        ]);

        $sqlTotal = "SELECT COUNT(*) FROM lesson 
             INNER JOIN section ON lesson.sectionId = section.id
             WHERE section.courseId = :courseId";
        $stmtTotal = $pdo->prepare($sqlTotal);
        $stmtTotal->execute(['courseId' => $courseId]);
        $totalLessons = $stmtTotal->fetchColumn();

        // Step 2: Get lessons completed by user
        $sqlCompleted = "SELECT COUNT(*) FROM progress
         WHERE courseId = :courseId AND userId = :userId AND status = 'completed'";
        $stmtCompleted = $pdo->prepare($sqlCompleted);
        $stmtCompleted->execute(['courseId' => $courseId, 'userId' => $userId]);
        $lessonsCompleted = $stmtCompleted->fetchColumn();

            $completionPercentage = ($totalLessons > 0) 
        ? ($lessonsCompleted / $totalLessons) * 100 
        : 0;

        if ($completionPercentage >= 100) {
    $sqlBadge = "INSERT INTO studentbadge (userId, courseId, badgeId) 
                 VALUES (:userId, :courseId, 1)";
    $stmtBadge = $pdo->prepare($sqlBadge);
    $stmtBadge->execute(['userId' => $userId, 'courseId' => $courseId]);
}

        
    }

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
}
