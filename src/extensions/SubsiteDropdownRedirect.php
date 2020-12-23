<?php

    namespace Hamaka\Extensions;

    use SilverStripe\Control\Controller;
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
            Requirements::javascript('hamaka/app:client/javascript/SubsiteDropdownRedirect.js');
        }

        public function HmkListSubsites()
        {
            $list             = Subsite::all_accessible_sites();
            $currentSubsiteID = SubsiteState::singleton()->getSubsiteId();

            if ($list == null || $list->count() == 1 && $list->first()->DefaultSite == true) {
                return false;
            }

            Requirements::javascript('hamaka/app:client/javascript/SubsiteDropdownRedirect.js');

            $output    = ArrayList::create();
            $sAdminUrl = 'admin';

            // voor localhost nog een mapnaam voor de admin-url plakken
            $localHostFolder = explode('/', $_SERVER['REQUEST_URI'])[1];
            if (strpos($localHostFolder, '.nl') !== false) {
                $sAdminUrl = $localHostFolder . '/admin';
            }

            foreach ($list as $subsite) {
                $currentState = $subsite->ID == $currentSubsiteID ? 'selected' : '';

                $domainURL    = '';
                $domainObject = $subsite->getPrimarySubsiteDomain();
                if ($domainObject) {
                    $domainURL = Controller::join_links($domainObject->Link(), $sAdminUrl);
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
