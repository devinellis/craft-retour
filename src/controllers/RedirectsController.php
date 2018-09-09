<?php
/**
 * Retour plugin for Craft CMS 3.x
 *
 * Retour allows you to intelligently redirect legacy URLs, so that you don't
 * lose SEO value when rebuilding & restructuring a website
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\retour\controllers;

use nystudio107\retour\Retour;
use nystudio107\retour\assetbundles\retour\RetourAsset;
use nystudio107\retour\assetbundles\retour\RetourRedirectsAsset;
use nystudio107\retour\helpers\MultiSite as MultiSiteHelper;
use nystudio107\retour\helpers\Permission as PermissionHelper;
use nystudio107\retour\models\StaticRedirects as StaticRedirectsModel;

use Craft;
use craft\web\Controller;
use craft\helpers\UrlHelper;

use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Retour
 * @since     3.0.0
 */
class RedirectsController extends Controller
{
    // Constants
    // =========================================================================

    const DOCUMENTATION_URL = 'https://github.com/nystudio107/craft-retour/';

    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * Show the redirects table
     *
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRedirects(string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('retour:redirects');
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Retour::$settings->pluginName;
        $templateTitle = Craft::t('retour', 'Redirects');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(RetourRedirectsAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/retour/assetbundles/retour/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'dashboard';

        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('retour'),
            ],
            [
                'label' => $templateTitle,
                'url' => UrlHelper::cpUrl('retour/redirects'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'redirects';

        // Render the template
        return $this->renderTemplate('retour/redirects/index', $variables);
    }

    /**
     * Edit the redirect
     *
     * @param int                       $redirectId
     * @param null|string               $siteHandle
     * @param null|StaticRedirectsModel $redirect
     *
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEditRedirect(
        int $redirectId,
        string $siteHandle = null,
        StaticRedirectsModel $redirect = null
    ): Response {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('retour:redirects');
        // Load in the redirect
        if ($redirectId === 0) {
            $redirect = new StaticRedirectsModel();
        }
        if ($redirect === null) {
            $redirectConfig = Retour::$plugin->redirects->getRedirectById($redirectId);
            if ($redirectConfig === null) {
                $redirectConfig = [];
                Craft::error(
                    Craft::t(
                        'retour',
                        "Couldn't load redirect id {id}",
                        ['id' => $redirectId]
                    ),
                    __METHOD__
                );
            }
            $redirect = new StaticRedirectsModel($redirectConfig);
        }
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Retour::$settings->pluginName;
        $templateTitle = Craft::t('retour', 'Edit Redirect');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(RetourAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/retour/assetbundles/retour/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'dashboard';

        // Basic variables
        $variables['fullPageForm'] = true;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('retour'),
            ],
            [
                'label' => 'Redirects',
                'url' => UrlHelper::cpUrl('retour/redirects'),
            ],
            [
                'label' => $templateTitle,
                'url' => UrlHelper::cpUrl('retour/edit-redirect/'.$redirectId),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - Redirects - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'redirects';
        $variables['redirect'] = $redirect;

        // Render the template
        return $this->renderTemplate('retour/redirects/_edit', $variables);
    }

    /**
     * Save the redirect
     *
     * @return null|Response
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionSaveRedirect()
    {
        PermissionHelper::controllerPermissionCheck('retour:settings');
        $this->requirePostRequest();
        /** @var StaticRedirectsModel $redirect */
        $redirectConfig = Craft::$app->getRequest()->getRequiredBodyParam('redirectConfig');
        if ($redirectConfig === null) {
            throw new NotFoundHttpException('Redirect not found');
        }
        $redirect = new StaticRedirectsModel($redirectConfig);
        // Make sure the redirect validates
        if (!$redirect->validate()) {
            Craft::$app->getSession()->setError(Craft::t('app', "Couldn't save redirect settings."));
            // Send the redirect back to the template
            Craft::$app->getUrlManager()->setRouteParams([
                'redirect' => $redirect,
            ]);

            return null;
        }
        // Save the redirect
        $redirectConfig = $redirect->getAttributes();
        Retour::$plugin->redirects->saveRedirect($redirectConfig);
        // Clear the caches and continue on
        Retour::$plugin->clearAllCaches();
        Craft::$app->getSession()->setNotice(Craft::t('app', 'Redirect settings saved.'));

        return $this->redirectToPostedUrl();
    }
}
