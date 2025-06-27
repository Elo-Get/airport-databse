<?php

use Doctrine\ORM\Mapping as ORM;

require_once __DIR__ . '/../vendor/autoload.php';

$entityPath = realpath(__DIR__ . '/../src/Entity');

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($entityPath));

foreach ($rii as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') continue;

    $filename = $file->getRealPath();
    $content = file_get_contents($filename);

    // Extraire le namespace et la classe
    preg_match('/namespace\s+([^;]+);/', $content, $nsMatch);
    preg_match('/class\s+([^\s]+)/', $content, $classMatch);

    if (!isset($nsMatch[1]) || !isset($classMatch[1])) continue;

    $fqcn = $nsMatch[1] . '\\' . $classMatch[1];

    if (!class_exists($fqcn)) {
        require_once $filename;
        if (!class_exists($fqcn)) continue;
    }

    $rc = new ReflectionClass($fqcn);
    echo "Class: " . $rc->getName() . "\n";

    // ---- Propriétés ----
    foreach ($rc->getProperties() as $property) {
        $type = $property->getType();
        $typeName = $type ? ($type instanceof ReflectionNamedType ? $type->getName() : 'mixed') : 'unknown';
        $nullable = $type && $type->allowsNull() ? 'true' : 'false';

        echo "  Property: $" . $property->getName() . " (type: $typeName, nullable: $nullable";

        // Relation ORM
        foreach ($property->getAttributes() as $attr) {
            $attrName = $attr->getName();

            if (in_array($attrName, [
                ORM\OneToOne::class,
                ORM\OneToMany::class,
                ORM\ManyToOne::class,
                ORM\ManyToMany::class,
            ])) {
                $relationType = (new ReflectionClass($attrName))->getShortName();
                $args = $attr->getArguments();
                $target = $args['targetEntity'] ?? 'unknown';
                echo ", relation: $relationType, target: $target";
                break;
            }
        }

        echo ")\n";
    }

    // ---- Méthodes ----
    foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->class !== $rc->getName()) continue;

        $methodLine = "  Method: " . $method->getName() . "(";

        // Paramètres
        $params = [];
        foreach ($method->getParameters() as $param) {
            $paramType = $param->getType();
            $paramTypeName = $paramType instanceof ReflectionNamedType ? $paramType->getName() : 'mixed';
            $paramNullable = $paramType && $paramType->allowsNull() ? 'nullable' : 'not nullable';
            $params[] = $param->getName() . ': ' . $paramTypeName . ' (' . $paramNullable . ')';
        }

        $methodLine .= implode(', ', $params) . ')';

        // Type de retour
        $returnType = $method->getReturnType();
        if ($returnType) {
            $returnTypeName = $returnType instanceof ReflectionNamedType ? $returnType->getName() : 'mixed';
            $returnNullable = $returnType->allowsNull() ? 'nullable' : 'not nullable';
            $methodLine .= ": " . $returnTypeName . " ($returnNullable)";
        }

        echo $methodLine . "\n";
    }

    echo str_repeat('-', 50) . "\n";
}
