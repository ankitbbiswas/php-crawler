<?php

// Ensure error reporting is enabled for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include other files
require_once 'checks/basics/frameworks.php';

// Include File Operations (FILEOPS) related files
require_once 'fileops/checkCsvInputFile.php';
require_once 'fileops/checkDirectory.php';
require_once 'fileops/checkFileExists.php';
require_once 'fileops/getCsvData.php';
require_once 'fileops/getMainDirectory.php';
require_once 'fileops/sanitizeFileName.php';
require_once 'fileops/saveAsHtmlFile.php';

// Include Logging functionalities
require_once 'logging/log_manager.php';

// Include CURL operations
require_once 'curl/curl_operations.php';

// Include basics checks
require_once 'checks/basics/CheckHTTP.php';
require_once 'checks/basics/ipaddress.php';
require_once 'checks/basics/tracking_providers.php';
require_once 'checks/basics/iscrawlable.php';

// Include cybersecurity checks
require_once 'checks/cybersecurity/Backups.php';
require_once 'checks/cybersecurity/CSP.php';
require_once 'checks/cybersecurity/CsrfProtection.php';
require_once 'checks/cybersecurity/DirectoryTraversal.php';
require_once 'checks/cybersecurity/FileInclusion.php';
require_once 'checks/cybersecurity/HSTS.php';
require_once 'checks/cybersecurity/OpenPorts.php';
require_once 'checks/cybersecurity/OutdatedLibraries.php';
require_once 'checks/cybersecurity/ReferrerPolicy.php';
require_once 'checks/cybersecurity/SqlInjectionRisk.php';
require_once 'checks/cybersecurity/SRI.php';
require_once 'checks/cybersecurity/Ssl.php';
require_once 'checks/cybersecurity/TwoFactorAuth.php';
require_once 'checks/cybersecurity/XContentTypeOptions.php';
require_once 'checks/cybersecurity/XFrameOptions.php';
require_once 'checks/cybersecurity/XMLRPC.php';
require_once 'checks/cybersecurity/XssRisk.php';

// Include GDPR checks
require_once 'checks/gdpr/Imprint.php';
require_once 'checks/gdpr/PrivacyDeclaration.php';

// Include PageSpeed checks
require_once 'checks/pagespeed/Value.php';

// Include SEO checks
require_once 'checks/seo/checkMobileFriendly.php';
require_once 'checks/seo/getCanonicalTags.php';
require_once 'checks/seo/getHeaderTagsCount.php';
require_once 'checks/seo/HreflangTags.php';
require_once 'checks/seo/Https.php';
require_once 'checks/seo/MetaDescription.php';
require_once 'checks/seo/NapConsistency.php';
require_once 'checks/seo/RobotsTxt.php';
require_once 'checks/seo/SecurityCertificate.php';
require_once 'checks/seo/Sitemap.php';
require_once 'checks/seo/StructuredData.php';
require_once 'checks/seo/TitleTag.php';

// Main process
function main() {
    // Initialize necessary directories
    $libraryDirectory = __DIR__;  // This gives the path to the current file (i.e., the library directory)
    $CSV_INPUT_DIRECTORY = $libraryDirectory . "/CSV_INPUT";
    $CSV_RESULT_DIRECTORY = $libraryDirectory . "/CSV_RESULT";
    $LOG_DIRECTORY = $libraryDirectory . "/LOG_DIRECTORY";
    $LOG_FILENAME = "logfile.txt";
    
    // Define the API key before using it
    $apiKey = 'AIzaSyDNiC1m8gdJiW3S-TKySXms0sZwQPn--Lk'; // Replace with your actual Google API key

    // Check if necessary directories exist or create them if they don't
    checkDirectory($CSV_INPUT_DIRECTORY);
    checkDirectory($CSV_RESULT_DIRECTORY);
    checkDirectory($LOG_DIRECTORY);

    // Check for CSV input file
    if (!checkCsvInputFile($CSV_INPUT_DIRECTORY, "/INPUT_CSV.csv")) {
        die("CSV input file not found.\n");
    }

    // Initialize logging
    $logManager = new LogManager($LOG_DIRECTORY, $LOG_FILENAME);
    $logManager->logMessage("Crawler started.");

    // Get CSV data
    $csvInputFile = $CSV_INPUT_DIRECTORY . "/INPUT_CSV.csv";
    $urlArray = getCsvData($csvInputFile);

    // Output results to CSV
    $timestamp = date('Ymd_His');
    $csvResultFile = fopen($CSV_RESULT_DIRECTORY . "/results_" . $timestamp . ".csv", 'w');
    if (!$csvResultFile) {
        $logManager->logMessage("Failed to open result CSV file.");
        exit();
    }

    // Write header to the result CSV
    fputcsv($csvResultFile, [
        'URL', 'IP Address', 'Crawlability Status', 'Original URL Status', 'https:// Status', 'http:// Status',
        'https://www. Status', 'http://www. Status', 'CheckImprint', 'Checkdataprivacy', 'CheckForTracking',
        'Framework', 'Backups', 'CSP', 'CsrfProtection', 'DirectoryTraversal', 'FileInclusion',
        'HSTS', 'OpenPorts', 'OutdatedLibraries', 'ReferrerPolicy', 'SqlInjectionRisk', 'SRI', 'Ssl',
        'TwoFactorAuth', 'XContentTypeOptions', 'XFrameOptions', 'XMLRPC', 'XssRisk', 'Pagespeed',
        'CanonicalTags', 'HeaderTagsCount', 'HreflangTags', 'HTTPS', 'MetaDescription', 'MobileFriendly',
        'NAPConsistency', 'RobotsTxt', 'SecurityCertificate', 'Sitemap', 'StructuredData', 'TitleTag'
    ]);

    // Crawl each URL
    foreach ($urlArray as $url) {
        $sourceCode = fetchSourceCode($url);
        if ($sourceCode === false) {
            $logManager->logMessage("Failed to fetch source code for URL: $url");
            continue;
        }

        // Check HTTP Statuses for different URL variations
        $httpStatuses = CheckHTTP($url);

        // Extract statuses for different URL variations
        $originalStatus = isset($httpStatuses['Original URL']) ? $httpStatuses['Original URL'] : 'Error';
        $httpsStatus = isset($httpStatuses['https:// Status']) ? $httpStatuses['https:// Status'] : 'Error';
        $httpStatus = isset($httpStatuses['http:// Status']) ? $httpStatuses['http:// Status'] : 'Error';
        $httpsWwwStatus = isset($httpStatuses['https://www. Status']) ? $httpStatuses['https://www. Status'] : 'Error';
        $httpWwwStatus = isset($httpStatuses['http://www. Status']) ? $httpStatuses['http://www. Status'] : 'Error';

        // Perform various checks
        $ipAddress = getIpAddress($url);
        $crawlability = isCrawlable($url);
        $crawlableStatus = isCrawlable($url);
        $imprintStatus = CheckImprint($sourceCode);
        $checkdataprivacy = CheckDataPrivacy($sourcecode);
        $checkForTracking = CheckForTracking($sourceCode);
        $framework = identifyFramework($sourceCode);
        $hsts = checkHSTS($sourceCode);
        $OpenPorts = checkOpenPorts($url);
        $OutdatedLibraries = checkOutdatedLibraries($sourceCode);
        $ReferrerPolicy = checkReferrerPolicy($sourceCode);
        $SqlInjectionRisk = checkSqlInjectionRisk($url);
        $SRI = checkSRI($sourceCode);
        $Ssl = checkSSL($url);
        $TwoFactorAuth = checkTwoFactorAuth($sourceCode);

        // Call additional checks for cybersecurity, SEO, pagespeed, etc.
        $checkBackups = checkBackups($sourceCode);
        $csrfprotection = checkCSRFProtection($sourceCode);
        $headerTagsCountCheck = getHeaderTagsCount($sourceCode);
        $hreflangTagsCheck = checkHreflangTags($sourceCode);
        $metaDescriptionCheck = checkMetaDescription($sourceCode);
        $mobileFriendlyCheck = checkMobileFriendly($sourceCode);
        $XContentTypeOptions = checkXContentTypeOptions($sourceCode);
        $XFrameOptions = checkXFrameOptions($sourceCode);
        $XMLRPC = checkXMLRPC($sourceCode);
        $XssRisk = checkXSS($sourceCode);
        $CanonicalTags = getCanonicalTags($sourceCode);
        $HeaderTagsCount = getHeaderTagsCount($sourceCode);
        $HreflangTags = checkHreflangTags($sourceCode);
        $HTTPS = checkHttps($url);
        $MetaDescription = checkMetaDescription($sourceCode);
        $MobileFriendly = checkMobileFriendly($sourceCode);
        $NAPConsistency = checkNapConsistency($sourceCode, $name, $address, $phone);
        $RobotsTxt = checkRobotsTxt($url);
        $SecurityCertificate = checkSecurityCertificates($url);
        $Sitemap = checkSitemap($url);
        $StructuredData = checkStructuredData($sourceCode);
        $TitleTag = checkTitleTag($sourceCode);
        $getpagespeed = getPageSpeedScores($url, $apiKey);

        // Log and write results
        fputcsv($csvResultFile, [
            $url, $ipAddress, $crawlableStatus, $originalStatus, $httpsStatus, $httpStatus, 
            $httpsWwwStatus, $httpWwwStatus, $imprintStatus, $checkdataprivacy, $checkForTracking,
            $framework, $checkBackups, $headerTagsCountCheck, $hreflangTagsCheck, $metaDescriptionCheck, $mobileFriendlyCheck,
            $hsts, $OpenPorts, $OutdatedLibraries, $ReferrerPolicy, $SqlInjectionRisk, $SRI, $Ssl, $TwoFactorAuth, $XContentTypeOptions,
            $XFrameOptions, $XMLRPC, $XssRisk, $getpagespeed, $CanonicalTags, $HeaderTagsCount, $HreflangTags, $HTTPS, $MetaDescription,
            $MobileFriendly, $NAPConsistency, $RobotsTxt, $SecurityCertificate, $Sitemap, $StructuredData, $TitleTag
        ]);
    }

    // Close files
    fclose($csvResultFile);
    $logManager->logMessage("Crawler completed successfully.");
}

// Call the main function
main();