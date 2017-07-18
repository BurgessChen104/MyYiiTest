<?php namespace Rollbar;

use Rollbar\Utilities;
use Rollbar\Payload\Notifier;
use Psr\Log\LogLevel;

class Defaults
{
    private static $singleton = null;

    public static function get()
    {
        if (is_null(self::$singleton)) {
            self::$singleton = new Defaults(new Utilities());
        }
        return self::$singleton;
    }

    private static function getGitHash()
    {
        try {
            if (function_exists('exec')) {
                exec('git rev-parse --verify HEAD 2> /dev/null', $output);
                if ($output) {
                    return $output[0];
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private static function getGitBranch()
    {
        try {
            if (function_exists('exec')) {
                exec('git rev-parse --abbrev-ref HEAD 2> /dev/null', $output);
                if ($output) {
                    return $output[0];
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private static function getServerRoot()
    {
        return isset($_ENV["HEROKU_APP_DIR"]) ? $_ENV["HEROKU_APP_DIR"] : null;
    }

    private static function getPlatform()
    {
        return php_uname('a');
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess) Static access to default notifier
     * intended.
     */
    private static function getNotifier()
    {
        return Notifier::defaultNotifier();
    }

    private static function getBaseException()
    {
        return version_compare(phpversion(), '7.0', '<')
            ? '\Exception'
            : '\Throwable';
    }

    private static function getScrubFields()
    {
        return array(
            'passwd',
            'password',
            'secret',
            'confirm_password',
            'password_confirmation',
            'auth_token',
            'csrf_token',
            'access_token'
        );
    }
    
    public function sendMessageTrace($sendMessageTrace = null)
    {
        return $sendMessageTrace !== null ? $sendMessageTrace : $this->defaultSendMessageTrace;
    }
    
    public function captureErrorStacktraces($capture = null)
    {
        return $capture !== null ?
            $capture :
            $this->defaultCaptureErrorStacktraces;
    }
    
    public function localVarsDump($localVarsDump = null)
    {
        return $localVarsDump !== null ? $localVarsDump : $this->defaultLocalVarsDump;
    }

    public function rawRequestBody($rawRequestBody = null)
    {
        return $rawRequestBody !== null ? $rawRequestBody : $this->defaultRawRequestBody;
    }

    private $defaultMessageLevel = "warning";
    private $defaultExceptionLevel = "error";
    private $defaultPsrLevels;
    private $defaultCodeVersion;
    private $defaultErrorLevels;
    private $defaultGitHash;
    private $defaultGitBranch;
    private $defaultServerRoot;
    private $defaultPlatform;
    private $defaultNotifier;
    private $defaultBaseException;
    private $defaultScrubFields;
    private $defaultSendMessageTrace;
    private $defaultIncludeCodeContext;
    private $defaultIncludeExcCodeContext;
    private $defaultRawRequestBody;
    private $defaultLocalVarsDump;
    private $defaultCaptureErrorStacktraces;
    private $utilities;

    public function __construct($utilties)
    {
        $this->defaultPsrLevels = array(
            LogLevel::EMERGENCY => "critical",
            "emergency" => "critical",
            LogLevel::ALERT => "critical",
            "alert" => "critical",
            LogLevel::CRITICAL => "critical",
            "critical" => "critical",
            LogLevel::ERROR => "error",
            "error" => "error",
            LogLevel::WARNING => "warning",
            "warning" => "warning",
            LogLevel::NOTICE => "info",
            "notice" => "info",
            LogLevel::INFO => "info",
            "info" => "info",
            LogLevel::DEBUG => "debug",
            "debug" => "debug"
        );
        $this->defaultErrorLevels = array(
            E_ERROR => "error",
            E_WARNING => "warning",
            E_PARSE => "critical",
            E_NOTICE => "debug",
            E_CORE_ERROR => "critical",
            E_CORE_WARNING => "warning",
            E_COMPILE_ERROR => "critical",
            E_COMPILE_WARNING => "warning",
            E_USER_ERROR => "error",
            E_USER_WARNING => "warning",
            E_USER_NOTICE => "debug",
            E_STRICT => "info",
            E_RECOVERABLE_ERROR => "error",
            E_DEPRECATED => "info",
            E_USER_DEPRECATED => "info"
        );
        $this->defaultGitHash = self::getGitHash();
        $this->defaultGitBranch = self::getGitBranch();
        $this->defaultServerRoot = self::getServerRoot();
        $this->defaultPlatform = self::getPlatform();
        $this->defaultNotifier = self::getNotifier();
        $this->defaultBaseException = self::getBaseException();
        $this->defaultScrubFields = self::getScrubFields();
        $this->defaultCodeVersion = "";
        $this->defaultSendMessageTrace = false;
        $this->defaultIncludeCodeContext = false;
        $this->defaultIncludeExcCodeContext = false;
        $this->defaultRawRequestBody = false;
        $this->defaultLocalVarsDump = false;
        $this->defaultCaptureErrorStacktraces = true;
        
        $this->utilities = $utilties;
    }

    public function messageLevel($level = null)
    {
        return $this->utilities->coalesce($level, $this->defaultMessageLevel);
    }

    public function exceptionLevel($level = null)
    {
        return $this->utilities->coalesce($level, $this->defaultExceptionLevel);
    }

    public function errorLevels($level = null)
    {
        return $this->utilities->coalesce($level, $this->defaultErrorLevels);
    }
    
    public function psrLevels($level = null)
    {
        return $this->utilities->coalesce($level, $this->defaultPsrLevels);
    }

    public function codeVersion($codeVersion = null)
    {
        return $this->utilities->coalesce(
            $codeVersion,
            $this->defaultCodeVersion
        );
    }

    public function gitHash($gitHash = null)
    {
        return $this->utilities->coalesce($gitHash, $this->defaultGitHash);
    }

    public function gitBranch($gitBranch = null)
    {
        return $this->utilities->coalesce($gitBranch, $this->defaultGitBranch);
    }

    public function serverRoot($serverRoot = null)
    {
        return $this->utilities->coalesce(
            $serverRoot,
            $this->defaultServerRoot
        );
    }

    public function platform($platform = null)
    {
        return $this->utilities->coalesce($platform, $this->defaultPlatform);
    }

    public function notifier($notifier = null)
    {
        return $this->utilities->coalesce($notifier, $this->defaultNotifier);
    }

    public function baseException($baseException = null)
    {
        return $this->utilities->coalesce(
            $baseException,
            $this->defaultBaseException
        );
    }

    public function scrubFields($scrubFields = null)
    {
        return $this->utilities->coalesce(
            $scrubFields,
            $this->defaultScrubFields
        );
    }

    public function includeCodeContext($includeCodeContext = null)
    {
        return $this->utilities->coalesce(
            $includeCodeContext,
            $this->defaultIncludeCodeContext
        );
    }

    public function includeExcCodeContext($includeExcCodeContext = null)
    {
        return $this->utilities->coalesce(
            $includeExcCodeContext,
            $this->defaultIncludeExcCodeContext
        );
    }
}
