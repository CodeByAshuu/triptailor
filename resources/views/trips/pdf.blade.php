<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export PDF - {{ $trip->title }}</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #111; 
            line-height: 1.6; 
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 40px 20px; 
        }
        .header {
            border-bottom: 2px solid #111;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .header h1 { 
            margin: 0; 
            font-size: 32px;
            letter-spacing: -0.5px;
        }
        .header .destination {
            color: #666;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }
        .print-btn {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .print-btn:hover {
            background: #4338ca;
        }
        .section {
            margin-bottom: 30px;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #eaeaea;
        }
        .section h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: 600;
        }
        .tags { 
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .tag { 
            background: #e0e7ff; 
            color: #3730a3;
            padding: 4px 10px; 
            border-radius: 100px; 
            font-size: 12px;
            font-weight: 600;
        }
        .footer { 
            margin-top: 50px; 
            border-top: 1px solid #eee; 
            padding-top: 20px; 
            font-size: 12px; 
            color: #999; 
            text-align: center;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .container { padding: 0; max-width: 100%; }
            .section { break-inside: avoid; background: white; border: 1px solid #ddd; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="no-print" style="text-align: right;">
            <button class="print-btn" onclick="window.print()">Print / Save as PDF</button>
        </div>
        
        <div class="header">
            <div>
                <h1>{{ $trip->title }}</h1>
                <div class="destination">{{ $trip->destination }}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: bold; font-size: 24px;">Trip Details</div>
                <div style="color: #666;">Generated via TripTailor</div>
            </div>
        </div>
        
        <div class="section">
            <h3>Overview</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Start Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($trip->start_date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">End Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($trip->end_date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Duration</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays(\Carbon\Carbon::parse($trip->end_date)) + 1 }} Days
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Estimated Budget</span>
                    <span class="detail-value">
                        @if($trip->budget)
                            ₹{{ number_format($trip->budget, 2) }}
                        @else
                            Not Specified
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        @if($trip->notes)
        <div class="section">
            <h3>Trip Notes</h3>
            <div style="white-space: pre-wrap;">{{ $trip->notes }}</div>
        </div>
        @endif
        
        @if(is_array($trip->tags) && count($trip->tags) > 0)
        <div class="section">
            <h3>Labels & Tags</h3>
            <div class="tags">
                @foreach($trip->tags as $tag)
                    <span class="tag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="footer">
            TripTailor &copy; {{ now()->format('Y') }} • Document generated on {{ now()->format('F j, Y, g:i a') }}
        </div>
    </div>
</body>
</html>
