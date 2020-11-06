<?php


namespace App\Helpers;
use Google_Client;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_ReportRequest;

class AnalyticsHelper
{
    public static function initAnalyticsReporting()
    {

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = __DIR__ .'/client_secrets.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("EGOV");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_AnalyticsReporting($client);
        return $analytics;
    }

    public static function initAnalytics()
    {

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = __DIR__ .'/client_secrets.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("EGOV");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);
        return $analytics;
    }

    public static function getReport($analytics, $id) {

        // Replace with your view ID, for example XXXX.
        $VIEW_ID = $id; //

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate("7daysAgo");
        $dateRange->setEndDate("yesterday");

        // Create the Metrics object.
        $sessions = new Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");

        $bounce_rate = new Google_Service_AnalyticsReporting_Metric();
        $bounce_rate->setExpression("ga:bounceRate");
        $bounce_rate->setAlias("bounceRate");

        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression("ga:users");
        $users->setAlias("users");

        // Create the ReportRequest object.
        $request_session = new Google_Service_AnalyticsReporting_ReportRequest();
        $request_session->setViewId($VIEW_ID);
        $request_session->setDateRanges($dateRange);
        $request_session->setMetrics(array($users, $sessions,$bounce_rate));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request_session) );
        return $analytics->reports->batchGet( $body );
    }

    public static function obtainUserStats($analytics, $id){
        $VIEW_ID = $id;

        $first_dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $first_dateRange->setStartDate('14daysAgo');
        $first_dateRange->setEndDate('8daysAgo');

        $second_dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $second_dateRange->setStartDate('7daysAgo');
        $second_dateRange->setEndDate('yesterday');

        $metric = new Google_Service_AnalyticsReporting_Metric();
        $metric->setExpression('ga:users');
        $metric->setAlias('users');

        $dimension = new \Google_Service_AnalyticsReporting_Dimension();
        $dimension->setName('ga:date');

        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($first_dateRange, $second_dateRange));
        $request->setDimensions(array($dimension));
        $request->setMetrics(array($metric));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }

    public static function obtainSessionStats($analytics, $id){
        $VIEW_ID = $id;

        $first_dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $first_dateRange->setStartDate('14daysAgo');
        $first_dateRange->setEndDate('8daysAgo');

        $second_dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $second_dateRange->setStartDate('7daysAgo');
        $second_dateRange->setEndDate('yesterday');

        $metric = new Google_Service_AnalyticsReporting_Metric();
        $metric->setExpression('ga:sessions');
        $metric->setAlias('sessions');

        $dimension = new \Google_Service_AnalyticsReporting_Dimension();
        $dimension->setName('ga:date');

        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($first_dateRange, $second_dateRange));
        $request->setMetrics(array($metric));
        $request->setDimensions(array($dimension));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        return $analytics->reports->batchGet( $body );
    }

}
