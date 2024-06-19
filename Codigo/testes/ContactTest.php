<?php
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testContactSectionExists()
    {
        $contactPageContent = file_get_contents('/mnt/data/contact.php');
        $this->assertStringContainsString('<section class="contact_section"', $contactPageContent, "The contact section should exist in the HTML.");
    }
}
?>
