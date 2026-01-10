<?php

namespace FedexRest\Services\Ship\Type;

/**
 * Image type constants for shipping label formats
 * Supported formats: PDF, ZPLII, EPL2, PNG
 */
class ImageType
{
    /** PDF format for shipping labels */
    const _PDF = 'PDF';
    /** ZPLII (Zebra Programming Language II) format for thermal printers */
    const _ZPLII = 'ZPLII';
    /** EPL2 (Eltron Programming Language 2) format for thermal printers */
    const _EPL2 = 'EPL2';
    /** PNG image format for shipping labels */
    const _PNG = 'PNG';
}
