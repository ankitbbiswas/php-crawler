<?php

class LogManager {
    private $logDirectory;
    private $logFilename;
    private $logFilePath;

    /**
     * Constructor for LogManager
     *
     * @param string $logDirectory Path to the log directory
     * @param string $logFilename Name of the log file
     */
    public function __construct($logDirectory, $logFilename) {
        $this->logDirectory = $logDirectory;
        $this->logFilename = $logFilename;
        $this->logFilePath = $this->logDirectory . '/' . $this->logFilename;

        // Ensure log directory exists or create it
        if (!is_dir($this->logDirectory)) {
            mkdir($this->logDirectory, 0755, true); // Create directory if it doesn't exist
        }

        // Ensure the log file exists or create it
        if (!file_exists($this->logFilePath)) {
            $this->createLogFile();
        }
    }

    /**
     * Creates the log file.
     */
    private function createLogFile() {
        $fileHandle = fopen($this->logFilePath, 'w'); // Create an empty file
        if ($fileHandle === false) {
            die('Error: Unable to create the log file.');
        }
        fclose($fileHandle);
    }

    /**
     * Logs a message to the log file.
     *
     * @param string $message The message to log
     */
    public function logMessage($message) {
        $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        file_put_contents($this->logFilePath, $logMessage, FILE_APPEND | LOCK_EX); // Log message
    }

    /**
     * Logs an error message.
     *
     * @param string $errorMessage The error message to log
     */
    public function logError($errorMessage) {
        $this->logMessage('ERROR: ' . $errorMessage);
    }

    /**
     * Clears the log file.
     */
    public function clearLog() {
        file_put_contents($this->logFilePath, ''); // Clear the file content
    }

    /**
     * Get the content of the log file.
     *
     * @return string Content of the log file
     */
    public function getLogContent() {
        return file_get_contents($this->logFilePath);
    }
}

?>
