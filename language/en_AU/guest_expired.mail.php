subject: Guest voucher expired

{alternative:plain}

Dear Sir or Madam,

A guest voucher from {guest.user_email} has expired.

Best regards,
{cfg:site_name}

{alternative:html}

<p>
    Dear Sir or Madam,
</p>

<p>
    A guest voucher from <a href="mailto:{guest.user_email}">{guest.user_email}</a> has expired.
</p>

<p>
    Best regards,<br />
    {cfg:site_name}
</p>
