%%------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ----------------------
%%-- Copyright © 2021 InterDigital R&D France
%% All Rights Reserved
%% Please refer to license.txt for the condition of use.
%%

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%% GENERATE PSEUDO RANDOM POSITIONS FOR TARGETS AND FILLERS OF ONE %%%%%
%%%%% PARTICIPANT BY FULLFILLING THE TWO FOLLOWING CONDITIONS: 45-100 %%%%%
%%%%% VIDEOS BETWEEN A TARGET AND ITS REPETITION, AND 3-6 FOR FILLERS %%%%%
%%%%% Romain Cohendet, 2017
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% PARAMETERS
number_of_draws_desired = 1000;
total_number_of_videos_in_a_sequence = 180;
filename = 'C:\Users\cohendetr\Desktop\Experiments\Expe_1_VM_crowdsourcing\positions_orders_tables.xlsx';%to save the table

% CREATE THE EMPTY positions_matrix (FINALLY SAVED IN THE MySQL TABLE)
positions_matrix = repmat(0,total_number_of_videos_in_a_sequence,1);

z=1;
while size(positions_matrix,2) < number_of_draws_desired

    %CREATE positions_videos TO STORE THE POSITIONS
        % vid_type_occurrence
            %column 1: video_id
            %column 2: type (target = 1, filler/vigilance = 0)
            %column 3: occurrence (first occurrence = 1, second occurrence = 2)
            %column 4: generated to store the positions
    positions_videos = [...
                        (1:180)',...
                        [repmat(0,40,1); repmat(1,80,1); repmat(0,60,1)],...
                        [repmat(1,20,1); repmat(2,20,1); repmat(1,40,1); repmat(2,40,1); repmat(1,60,1)],...
                        repmat(0,180,1)...
                        ];

    %CREATE A LIST OF AVAILABLE POSITIONS
        %column 1: position id
        %column 2: Availability of the positions (1=available, 0 = non available)
    list_available_positions = [(1:180)', repmat(1, 180,1)];
    
    
    %GENERATE POSITIONS FOR first OCCURRENCES OF THE 20 FILLERS of VIGILANCE
    %(180-7): 173, i.e. minus maw range + 1
    positions_videos(1,4) = round(1 + (99-1).*rand(1,1));%determine first position
    list_available_positions(list_available_positions(:,1)==positions_videos(1,4),2) = 0;%change 1 into 0 for the used position in the list_available_positions
    i=2;

    while i < 21
        positions_videos(i,4) = round(1 + (173-1).*rand(1,1));
        while ismember(positions_videos(i,4), list_available_positions(list_available_positions(:,2)==0,1))==1 | ismember(positions_videos(i,4),positions_videos(1:(i-1),4))==1 
            positions_videos(i,4) = round(1 + (173-1).*rand(1,1));
        end
    
        %change 1 into 0 for the used position in the list_available_positions
        list_available_positions(list_available_positions(:,1)==positions_videos(i,4),2) = 0;

        i= i+1;
    end

    %GENERATE POSITIONS FOR the 20 2nd OCCURRENCES OF THE FILLERS (VIGILANCE
    %REPEATS) - intervall between occurrence and reoccurrence: [3-6]
    while i < 41
        positions_videos(i,4) = positions_videos(i-20,4)+ round(3 + (6-3).*rand(1,1));
        limit1 = 1;
        while ismember(positions_videos(i,4), list_available_positions(list_available_positions(:,2)==0,1))==1 | ismember(positions_videos(i,4), positions_videos(1:(i-1),4))==1 
            positions_videos(i,4) = positions_videos(i-20,4)+ round(3 + (6-3).*rand(1,1));
            % If no solution after 100 tests
            if limit1 > 100
                break
            end
            limit1=limit1+1;
        end
  
        % If no solution after 100 tests
        if limit1 > 100
            break
        end
            
        %change 1 into 0 for the used position in the list_available_positions
        list_available_positions(list_available_positions(:,1)==positions_videos(i,4),2) = 0;
 
        i= i+1;
    end

    %GENERATE RANDOM POSITIONS FOR THE 40 FIRST OCCURRENCES OF TARGETS
        %requirement: positions must be between 1 and 100 (i.e. 180-100 = max gap)
    % Generate values from the uniform distribution on the interval [1, 80]
    while i < 81
        positions_videos(i,4) = round(1 + (79-1).*rand(1,1));%99 because of round function
        while ismember(positions_videos(i,4), list_available_positions(list_available_positions(:,2)==0,1))==1 | ismember(positions_videos(i,4),positions_videos(1:(i-1),4))==1 
            positions_videos(i,4) = round(1 + (79-1).*rand(1,1));
        end
    
        %change 1 into 0 for the used position in the list_available_positions
        list_available_positions(list_available_positions(:,1)==positions_videos(i,4),2) = 0;

        i= i+1;
    end

    %GENERATE THE POSITIONS OF THE SECOND OCCURRENCES OF THE TARGETS BETWEEN 45 and 100
    while i < 121
        positions_videos(i,4) = positions_videos(i-40,4)+ round(45 + (100-45).*rand(1,1));
        limit2 = 1;
        while ismember(positions_videos(i,4), list_available_positions(list_available_positions(:,2)==0,1))==1 | ismember(positions_videos(i,4), positions_videos(1:(i-1),4))==1
            positions_videos(i,4) = positions_videos(i-40,4)+ round(45 + (100-45).*rand(1,1));
            % If no solution after 100 tests, break the whole processe and re-run the
            % algo from the beginning
            if limit2 > 100
                break
            end
            limit2 = limit2+1;
        end
        
        % If no solution after 100 tests
        if limit2 > 100
            break
        end
                
        %change 1 into 0 for the used position in the list_available_positions
        list_available_positions(list_available_positions(:,1)==positions_videos(i,4),2) = 0;
 
        i= i+1;
    end
     
    % FILL THE BLANK POSITIONS WITH THE 60 REMAINING FILLERS
    while i < 181
        %select a random position among available position
        positions_videos(i,4) = datasample(list_available_positions(list_available_positions(:,2)==1,1),1);
   
        %change 1 into 0 for the used position in the list_available_positions
        list_available_positions(list_available_positions(:,1)==positions_videos(i,4),2) = 0;
 
        i= i+1;
    end

    %END CONTROL
    if sum(1:180) == sum(unique(positions_videos(:,4)))
        disp('It worked perfectly well!');
    else
        disp('You are so a bad bitch!');
    end

    %SAVE THE RESULTS IN THE positions_matrix
    positions_matrix(1:length(positions_videos(:,4)),z) = positions_videos(:,4);

    z = z+1;
end

%SAVE THE SEQUENCES OF POSITIONS IN AN EXCEL SPREADSHEET TO BE IMPORTED IN A MySQL TABLE

%add the labels id_sequences (from 1 to number_of_draws_desired)
id_sequence = [];
u = 1;
while u < number_of_draws_desired+1
    tmp = repmat(u,180,1);
    id_sequence = [id_sequence; tmp];
    u = u+1;
end

to_save = [id_sequence, repmat(positions_videos(:,1:3), number_of_draws_desired, 1), positions_matrix(:)];
xlswrite(filename, to_save)



