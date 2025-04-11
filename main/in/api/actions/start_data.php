<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$sql = "INSERT INTO interns (mail, name, surn, quest, deadline, status) VALUES
('michal0432@gmail.com','Michał','Kleczewski','https://github.com/michal04kl/cms',NULL,'completed'),
('anna.nowak@example.com','Anna','Nowak','https://github.com/michal04kl/chess',NULL,'completed'),
('david.brown@example.com','David','Brown',NULL,'2025-01-01 12:00:00','declined'),
('emily.davis@example.com','Emily','Davis',NULL,'2025-01-01 12:00:00','declined'),
('christopher.johnson@example.com','Christopher','Johnson',NULL,'2025-01-01 12:00:00','declined'),
('olivia.wilson@example.com','Olivia','Wilson',NULL,'2025-01-01 12:00:00','declined'),
('daniel.miller@example.com','Daniel','Miller',NULL,'2025-01-01 12:00:00','declined'),
('james.taylor@example.com','James','Taylor',NULL,'2025-12-31 23:59:59','waiting'),
('sophia.anderson@example.com','Sophia','Anderson',NULL,'2025-12-31 23:59:59','waiting'),
('benjamin.thomas@example.com','Benjamin','Thomas',NULL,'2025-12-31 23:59:59','waiting'),
('charlotte.martinez@example.com','Charlotte','Martinez',NULL,'2025-12-31 23:59:59','waiting'),
('henry.robinson@example.com','Henry','Robinson',NULL,'2025-12-31 23:59:59','waiting'),
('amelia.clark@example.com','Amelia','Clark',NULL,'2025-12-31 23:59:59','waiting'),
('elijah.rodriguez@example.com','Elijah','Rodriguez',NULL,'2025-12-31 23:59:59','waiting'),
('abigail.lewis@example.com','Abigail','Lewis',NULL,'2025-12-31 23:59:59','waiting'),
('alexander.lee@example.com','Alexander','Lee',NULL,'2025-12-31 23:59:59','waiting'),
('grace.walker@example.com','Grace','Walker',NULL,'2025-12-31 23:59:59','waiting'),
('liam.hill@example.com','Liam','Hill',NULL,NULL,'waiting'),
('emma.scott@example.com','Emma','Scott',NULL,NULL,'waiting'),
('noah.adams@example.com','Noah','Adams',NULL,NULL,'waiting');";
$sql2 = "INSERT INTO users (mail, login, passwd, rand, level) VALUES
('james.taylor@example.com','jtaylor','5bd1b26109d75e8956fb05b05c50982c30cb8eaa',NULL,'1'),
('sophia.anderson@example.com','sanderson','82d2bfa5881b175c501c3a9e0b8e8a9d4e7b2c60',NULL,'1'),
('benjamin.thomas@example.com','bthomas','ac3e1cf338b5f7af88e1a6aaef0d6037f5b9d2a1',NULL,'1'),
('charlotte.martinez@example.com','cmartinez','4efc7c3a845d2b709f8408cb89ab68fb6f0e4da7',NULL,'1'),
('henry.robinson@example.com','hrobinson','d9a4e299cd0c3d98e5fb7bf67c1a7b825e94c101',NULL,'1'),
('amelia.clark@example.com','aclark','96e5e82af3dcb5a9b87bb2c3a59a9dc3e5b1728e',NULL,'1'),
('elijah.rodriguez@example.com','erodriguez','3f9d8c1ad5a7c6b8c25a9d2e8a4f5d7e1f2c3a4b',NULL,'1'),
('abigail.lewis@example.com','alewis','c1e2d3f4a5b6c7d8e9f0a1b2c3d4e5f6a7b8c9d0',NULL,'1'),
('alexander.lee@example.com','alee','b0c9d8e7f6a5b4c3d2e1f0a9b8c7d6e5f4a3b2c1',NULL,'1'),
('grace.walker@example.com','gwalker','f1e2d3c4b5a69788776655443322110ffeeddbbc',NULL,'1'),
('liam.hill@example.com','lhill','a1b2c3d4e5f60718293a4b5c6d7e8f9012345678',NULL,'1'),
('emma.scott@example.com','escott','b2c3d4e5f60718293a4b5c6d7e8f9012345678a1',NULL,'1'),
('noah.adams@example.com','nadams','c3d4e5f60718293a4b5c6d7e8f9012345678a1b2',NULL,'1'),
('recruiter1@example.com','recruiter1','d4e5f60718293a4b5c6d7e8f9012345678a1b2c3',NULL,'2'),
('recruiter2@example.com','recruiter2','e5f60718293a4b5c6d7e8f9012345678a1b2c3d4',NULL,'2'),
('recruiter3@example.com','recruiter3','f60718293a4b5c6d7e8f9012345678a1b2c3d4e5',NULL,'2');";

// Sample credentials:
// Recruiter: login: recruiter1, password: recruiterPass_recruiter1
// Intern: login: jtaylor, password: internPass_jtaylor

$res = $data->query($sql) or die ('base error');
$res = $data->query($sql2) or die ('base error');
$data->close();
?>