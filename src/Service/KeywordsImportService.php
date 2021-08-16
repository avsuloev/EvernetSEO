<?php

namespace App\Service;

use App\Entity\Keyword;
use App\Entity\KeywordGroup;
use App\Entity\Project;
use App\Util\NestingHelper;
use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\Pure;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use Symfony\Component\DomCrawler\Crawler;

class KeywordsImportService
{
    private array $ormData;
    /**
     * @todo: check if omitting this property declaration is better solution.
     */
    public array $nestedGroups = [];
    /**
     * @var ArrayCollection|KeywordGroup[]
     */
    private ArrayCollection|array $kwGroups;
    /**
     * @var ArrayCollection|Keyword[]
     */
    private ArrayCollection|array $keywords;
    private NestingHelper         $helper;
    private Project               $project;

    #[Pure]
    public function __construct()
    {
        $this->helper   = new NestingHelper();
        $this->kwGroups = new ArrayCollection();
        $this->keywords = new ArrayCollection();
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function importFromXslx(string $path): self
    {
        $spreadsheet = IOFactory::load($path);
        $spreadsheet->getActiveSheet()->removeRow(1); // remove titles

        $this->ormData = $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true)
        ;

        return $this;
    }

    // public function importCsv(string $path) {
    // }

    public function toOrm(): self
    {
        foreach ($this->ormData as $entry) {
            ['A' => $kwName, 'B' => $kwGroupsString, 'C' => $kwFrequency] = $entry;
            $this->splitGroups($kwGroupsString, $kwName, $kwFrequency);
        }

        foreach ([$this->nestedGroups] as $group) {
            $this->prepareKwGroup($group);
        }

        return $this;
    }

    private function splitGroups(
        string $kwGroupsStr,
        string $kwName,
        ?int $kwFrequency,
    ): self {
        $groups = explode('->', $kwGroupsStr);
        $temp =& $this->nestedGroups;
        foreach($groups as $key) {
            if (!array_key_exists($key, $groups)) {
                $temp =& $temp[$key];
            }
        }
        $temp['kw_entries'][] = [
            'name' => $kwName,
            'frequency' => $kwFrequency,
        ];

        return $this;
    }

    private function prepareKwGroup(array $group): void
    {
        foreach ($group as $key => $value)
        {
            if ('kw_entries' === $key) {
                $this->prepareKeywords($value);
                // $this->helper->ascend();
                return;
            }

            $parent = $this->helper->parent();

            $kwGroup = new KeywordGroup();
            $kwGroup->setName($key);
            $kwGroup->setProject($this->project);
            if (null !== $parent) {
                $kwGroup->setSupergroup($parent);
            }
            // $kwGroup->setLevel($this->helper->lvl());

            $this->kwGroups->add($kwGroup);

            $this->helper->descend($kwGroup);
            $this->prepareKwGroup($value);
            $this->helper->ascend();
        }

        // $this->helper->ascend();
    }

    private function prepareKeywords(array $keywords): void
    {
        /** @var KeywordGroup $parent */
        $parent = $this->helper->parent();

        foreach ($keywords as $entry) {
            $newKw = new Keyword();
            $newKw->setName($entry['name']);
            $newKw->setFrequency($entry['frequency']);
            $parent->addKeyword($newKw);
            // $newKw->setKeywordGroup($parent);

            $this->keywords->add($newKw);
        }
    }

    public function getKwGroups(): ArrayCollection
    {
        return $this->kwGroups;
    }

    public function getKeywords(): ArrayCollection
    {
        return $this->keywords;
    }

    // public function importXml(string $path) {
    //     $this->crawler->addXmlContent(file_get_contents($path));
    // }
}
