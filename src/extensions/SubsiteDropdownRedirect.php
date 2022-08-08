<?php

    namespace Hamaka\SilverstripeSubsiteSwitchOwnDomain\Extension;

    use SilverStripe\Control\Controller;
    use SilverStripe\Core\Environment;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\DataExtension;
    use SilverStripe\Subsites\Model\Subsite;
    use SilverStripe\Subsites\State\SubsiteState;
    use SilverStripe\View\ArrayData;
    use SilverStripe\View\Requirements;

    class SubsiteDropdownRedirect extends DataExtension
    {

        public function init()
        {
            Requirements::javascript('hamaka/silverstripe-subsite-switch-own-domain:client/dist/js/SubsiteDropdownRedirect.js');
        }

        public function HmkListSubsites()
        {
            $list             = Subsite::all_accessible_sites();
            $currentSubsiteID = SubsiteState::singleton()->getSubsiteId();

            if ($list == null || $list->count() == 1 && $list->first()->DefaultSite == true) {
                return false;
            }

            Requirements::javascript('hamaka/silverstripe-subsite-switch-own-domain:client/dist/js/SubsiteDropdownRedirect.js');

            $output    = ArrayList::create();
            $sAdminUrl = 'admin';

            // if site is hosted in folder (localhost/project.com), fix this for subsite URL (@todo needs better solution)
            $localHostFolder = explode('/', $_SERVER['REQUEST_URI'])[1];
            if (strpos($localHostFolder, '.nl') !== false || strpos($localHostFolder, '.com') !== false) {
                $sAdminWithinFolder = $localHostFolder;
            }

            foreach ($list as $subsite) {
                $currentState = $subsite->ID == $currentSubsiteID ? 'selected' : '';

                $domainURL    = '';
                $domainObject = $subsite->getPrimarySubsiteDomain();
                if ($domainObject) {
                    $domainURL = Controller::join_links($domainObject->Link(), $sAdminWithinFolder, $sAdminUrl);
                }
                else {
                    $domainURL = Controller::join_links(Environment::getEnv('SS_BASE_URL'), $sAdminUrl);
                }

                $output->push(ArrayData::create([
                    'CurrentState' => $currentState,
                    'ID'           => $subsite->ID,
                    'Title'        => $subsite->Title,
                    'Link'         => $domainURL
                ]));
            }

            return $output;
        }
    }
