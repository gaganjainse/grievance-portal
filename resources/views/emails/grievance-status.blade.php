<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; padding: 30px;">
    <div style="max-width:600px; margin:0 auto; background:#fff; border-radius:12px; padding:30px;">
        <div style="text-align:center; border-bottom:2px solid #1a1a2e; padding-bottom:20px; margin-bottom:20px;">
            <h2 style="color:#1a1a2e; margin:0;">Grievance Portal</h2>
        </div>

        <p>Dear <strong>{{ $grievance->user->name }}</strong>,</p>

        <p>Your grievance <strong>#{{ $grievance->ticket_id }}</strong> has been updated.</p>

        <div style="background:#f8f9fa; border-radius:8px; padding:15px; margin:15px 0;">
            <p><strong>Status:</strong>
                <span style="display:inline-block; padding:3px 12px; border-radius:12px; font-size:.85rem; background:
                    @switch($grievance->status)
                        @case('resolved') #d4edda; color:#155724 @break
                        @case('rejected') #f8d7da; color:#721c24 @break
                        @case('in_progress') #cce5ff; color:#004085 @break
                        @default #fff3cd; color:#856404
                    @endswitch">
                    {{ ucfirst(str_replace('_', ' ', $grievance->status)) }}
                </span>
            </p>
            <p><strong>Subject:</strong> {{ $grievance->subject }}</p>
            @if($grievance->resolution_notes)
                <p><strong>Resolution Notes:</strong><br>{{ $grievance->resolution_notes }}</p>
            @endif
        </div>

        <p>You can track your grievance at any time by logging into the portal.</p>

        <div style="text-align:center; margin:25px 0;">
            <a href="{{ url('/citizen/grievances/' . $grievance->id) }}"
               style="display:inline-block;background:#1a1a2e;color:#fff;padding:12px 30px;border-radius:8px;text-decoration:none;">
               View Grievance
            </a>
        </div>

        <div style="border-top:1px solid #dee2e6; padding-top:15px; font-size:.85rem; color:#6c757d;">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Grievance Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
