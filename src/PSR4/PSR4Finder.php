<?php
namespace HaydenPierce\ClassFinder\PSR4;

use HaydenPierce\ClassFinder\Exception\ClassFinderException;
use HaydenPierce\ClassFinder\FinderInterface;

class PSR4Finder implements FinderInterface
{
    private $factory;

    public function __construct(PSR4NamespaceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param $namespace
     * @return bool|string
     * @throws ClassFinderException
     */
    public function findClasses($namespace)
    {
        $composerNamespaces = $this->factory->getPSR4Namespaces();

        /** @var PSR4Namespace $bestNamespace */
        $bestNamespace = array_reduce($composerNamespaces, function($carry, PSR4Namespace $potentialNamespace) use ($namespace) {
            if ($potentialNamespace->matches($namespace)) {
                return $potentialNamespace;
            } else {
                return $carry;
            }
        }, null);

        if ($bestNamespace instanceof PSR4Namespace) {
            return $bestNamespace->findClasses($namespace);
        } else {
            throw new ClassFinderException(sprintf("Unknown namespace '%s'. You should add the namespace prefix to composer.json. See '%s' for details.",
                $namespace,
                'https://gitlab.com/hpierce1102/ClassFinder/blob/master/docs/exceptions/unregisteredRoot.md'
            ));
        }
    }
}